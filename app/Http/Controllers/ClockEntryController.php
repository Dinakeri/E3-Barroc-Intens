<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClockEntryController extends Controller
{
    public function clockIn()
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $alreadyClockedIn = $user->clockEntries()->whereNull('end_time')->exists();

        if ($alreadyClockedIn) {
            return back()->with('status', 'Je bent al ingeclockt.');
        }

        $user->clockEntries()->create([
            'start_time' => now(),
        ]);

        return back()->with('status', 'Klok in geregistreerd.');
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $entry = $user->clockEntries()
            ->whereNull('end_time')
            ->orderByDesc('start_time')
            ->first();

        if (! $entry) {
            return back()->with('status', 'Je bent niet ingeclockt.');
        }

        $entry->update([
            'end_time' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('status', 'Klok uit geregistreerd.');
    }
}
