<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Installation;
use App\Models\Maintenance;
use App\Models\Fault;
class maintenanceController extends Controller
{
    public function fetchInboxEmails(): array
    {
        $emails = null;
        $mailError = null;

        try {
            if (!class_exists(\Webklex\IMAP\Facades\Client::class)) {
                throw new \Exception('Webklex IMAP package not installed. Run: composer require webklex/imap');
            }

            // Use the 'default' account from config/imap.php if available
            $client = \Webklex\IMAP\Facades\Client::account('default');
            $client->connect();

            // Try to get INBOX (case-insensitive)
            $folder = null;
            foreach ($client->getFolders() as $f) {
                if (strtolower($f->name) === 'inbox') { $folder = $f; break; }
            }
            if (is_null($folder)) {
                // fallback: take first folder
                $folder = $client->getFolders()->first();
            }

            // Use explicit 'all' selector so the client issues a valid SEARCH command
            // (Gmail returns BAD for an empty UID SEARCH). This will request all
            // messages and then we limit the result set locally.
            if ($folder) {
                try {
                    $query = $folder->messages()->all()->limit(20);
                    if (method_exists($query, 'setFetchBody')) {
                        $query->setFetchBody(false);
                    }
                    if (method_exists($query, 'setFetchFlags')) {
                        $query->setFetchFlags(false);
                    }
                    if (method_exists($query, 'setFetchOrder')) {
                        $query->setFetchOrder('desc');
                    }
                    $messages = $query->get();
                } catch (\Throwable $eMessages) {
                    // Fallback to a safer query: fetch the message list and slice
                    Log::debug('IMAP messages()->all() failed: ' . $eMessages->getMessage());
                    $all = $folder->messages()->get();
                    $messages = collect($all)->slice(0, 20);
                }
            } else {
                $messages = collect();
            }

            $emails = collect();
            foreach ($messages as $m) {
                $preview = '';
                try {
                    if (method_exists($m, 'getTextBody')) {
                        $preview = (string) ($m->getTextBody() ?: '');
                    }
                } catch (\Throwable $previewEx) {
                    $preview = '';
                }

                $emails->push([
                    'id' => (string)$m->getUid(),
                    'subject' => (string)$m->getSubject(),
                    'from' => optional($m->getFrom()[0])->mail ?? '',
                    'from_name' => optional($m->getFrom()[0])->personal ?? '',
                    'date' => $m->getDate(),
                    'preview' => $preview,
                ]);
            }

            // Check which emails are already scheduled
            $scheduled = Maintenance::whereNotNull('email_id')
                ->get(['email_id','Date']);
            $scheduledMap = [];
            foreach ($scheduled as $s) { $scheduledMap[$s->email_id] = $s->Date; }

            $emails = $emails->map(function($email) use ($scheduledMap) {
                $email['scheduled'] = array_key_exists($email['id'], $scheduledMap);
                $email['scheduled_at'] = $email['scheduled'] ? $scheduledMap[$email['id']] : null;
                return $email;
            });
        } catch (\Throwable $e) {
            $emails = null;
            $mailError = 'E-mails ophalen mislukt. Controleer de mailbox-instellingen.';

            // Log full exception and any client config for debugging
            try {
                Log::error('IMAP connection failed: ' . $e->getMessage(), [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);

                // If client was created, log its config (avoid exposing secrets in public logs!)
                if (isset($client) && method_exists($client, 'getConfig')) {
                    try {
                        $cfg = $client->getConfig();
                        Log::debug('IMAP client config (masked)', [
                            'host' => $cfg->get('host'),
                            'port' => $cfg->get('port'),
                            'encryption' => $cfg->get('encryption'),
                            'validate_cert' => $cfg->get('validate_cert'),
                            'username' => preg_replace('/(.)(.*)(@.*)/', '$1***$3', $cfg->get('username')),
                        ]);
                    } catch (\Throwable $ex2) {
                        Log::debug('Failed to get IMAP client config: ' . $ex2->getMessage());
                    }
                }
            } catch (\Throwable $logEx) {
                // ignore logging errors
            }
        }

        return compact('emails', 'mailError');
    }

    public function index()
    {
        $installationAmount = Installation::count();
        $maintenanceAmount = Maintenance::count();
        $incidentAmount = Fault::count();
        $recentMaintenances = Maintenance::orderByDesc('Date')
            ->take(8)
            ->get();

        return view('dashboards.maintenance', compact('installationAmount', 'maintenanceAmount', 'incidentAmount', 'recentMaintenances'));
    }
    public function repairs()
    {
        $workers = \App\Models\User::where('role', 'maintenance')->orderBy('name')->get();
        ['emails' => $emails, 'mailError' => $mailError] = $this->fetchInboxEmails();

        return view('maintenance.repairs', compact('emails', 'mailError', 'workers'));
    }
    public function calendar()
    {
        $maintenances = Maintenance::all();
        return view('maintenance.calendar', compact('maintenances'));
    }

    public function workerCalendar()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $userId = $user ? $user->id : null;
        $maintenances = Maintenance::where('AssignedTo', $userId)->get();
        return view('maintenance.workerCalendar', compact('maintenances'));
    }

    public function scheduleRepair(Request $request)
    {
        try {
            $validated = $request->validate([
                'email_id' => 'required',
                'from' => 'required|string',
                'date' => 'required|date',
                'time' => 'required',
                'assigned_to' => 'nullable|integer',
            ]);

            // Get optional fields without validation
            $subject = $request->input('subject', 'Reparatie');
            $fromName = $request->input('from_name', '');
            $notes = $request->input('notes', '');
            $assignedTo = $validated['assigned_to'] ?? null;

            // Ensure all values are strings
            $subject = is_array($subject) ? implode(', ', $subject) : (string)$subject;
            $fromName = is_array($fromName) ? implode(', ', $fromName) : (string)$fromName;
            $notes = is_array($notes) ? implode(', ', $notes) : (string)$notes;
            $from = is_array($validated['from']) ? implode(', ', $validated['from']) : (string)$validated['from'];

            // Build ISO datetime from date + time for calendar
            $dateTime = sprintf('%sT%s:00', $validated['date'], $validated['time']);

            // Log the data being sent
            Log::debug('Schedule repair data', [
                'subject' => $subject,
                'fromName' => $fromName,
                'notes' => $notes,
                'from' => $from,
                'date' => $validated['date'],
                'time' => $validated['time'],
                'dateTime' => $dateTime,
                'assigned_to' => $assignedTo,
            ]);
            // Check if this email is already scheduled
            $maintenance = Maintenance::where('email_id', $validated['email_id'])->first();

            if ($maintenance) {
                // Update existing repair (reschedule)
                $maintenance->update([
                    'Title' => $subject,
                    'Content' => 'Van: ' . ($fromName ?: $from) . "\n\n" . $notes,
                    'Date' => $dateTime,
                    'AssignedTo' => $assignedTo,
                ]);
                $message = 'Reparatie succesvol gewijzigd';
            } else {
                // Create new maintenance/repair record
                $maintenance = Maintenance::create([
                    'email_id' => $validated['email_id'],
                    'Title' => $subject,
                    'Content' => 'Van: ' . ($fromName ?: $from) . "\n\n" . $notes,
                    'Date' => $dateTime,
                    'AssignedTo' => $assignedTo,
                ]);
                $message = 'Reparatie succesvol ingepland';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'id' => $maintenance->id
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to schedule repair: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
