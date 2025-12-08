<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Installation;
use App\Models\Maintenance;
use App\Models\Fault;
class maintenanceController extends Controller
{
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
                    $messages = $folder->messages()->all()->limit(50)->get();
                } catch (\Throwable $eMessages) {
                    // Fallback to a safer query: fetch the message list and slice
                    Log::debug('IMAP messages()->all() failed: ' . $eMessages->getMessage());
                    $all = $folder->messages()->get();
                    $messages = collect($all)->slice(0, 50);
                }
            } else {
                $messages = collect();
            }

            $emails = collect();
            foreach ($messages as $m) {
                $emails->push([
                    'id' => $m->getUid(),
                    'subject' => $m->getSubject(),
                    'from' => optional($m->getFrom()[0])->mail ?? '',
                    'from_name' => optional($m->getFrom()[0])->personal ?? '',
                    'date' => $m->getDate(),
                    'preview' => $m->getTextBody() ?: $m->getHtmlBody(),
                ]);
            }
        } catch (\Throwable $e) {
            $emails = null;
            $mailError = $e->getMessage();

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

        return view('maintenance.repairs', compact('emails', 'mailError'));
    }
}
