<x-layouts.app :title="__('Urenoverzicht')">
    <div class="mx-auto w-full max-w-4xl space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">Urenoverzicht</h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $user->name }} · {{ $user->email }}</p>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-lg border border-neutral-300 px-3 py-2 text-sm font-medium text-neutral-700 hover:border-neutral-400 dark:border-neutral-700 dark:text-neutral-200">
                Terug
            </a>
        </div>

        @php
            $totalMinutes = $entries->sum(function ($entry) {
                if (! $entry->end_time) {
                    return 0;
                }

                return $entry->start_time->diffInMinutes($entry->end_time);
            });
            $hours = intdiv($totalMinutes, 60);
            $minutes = $totalMinutes % 60;
        @endphp

        <div class="rounded-xl border border-neutral-200 bg-white p-4 shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="text-sm text-neutral-500 dark:text-neutral-400">Totaal gewerkte tijd</div>
            <div class="text-2xl font-semibold text-neutral-900 dark:text-neutral-100">{{ $hours }}u {{ $minutes }}m</div>
        </div>

        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm dark:border-neutral-700 dark:bg-neutral-900">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-neutral-100 text-xs uppercase tracking-wide text-neutral-500 dark:bg-neutral-800 dark:text-neutral-400">
                        <tr>
                            <th class="px-4 py-3">Start</th>
                            <th class="px-4 py-3">Einde</th>
                            <th class="px-4 py-3">Duur</th>
                            <th class="px-4 py-3">Notities</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-200 dark:divide-neutral-800">
                        @forelse ($entries as $entry)
                            @php
                                $duration = $entry->end_time
                                    ? $entry->start_time->diff($entry->end_time)->format('%hh %im')
                                    : null;
                            @endphp
                            <tr>
                                <td class="px-4 py-3 text-neutral-900 dark:text-neutral-100">
                                    {{ $entry->start_time->format('d-m-Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-neutral-900 dark:text-neutral-100">
                                    {{ $entry->end_time?->format('d-m-Y H:i') ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-neutral-900 dark:text-neutral-100">
                                    {{ $duration ?? 'Bezig' }}
                                </td>
                                <td class="px-4 py-3 text-neutral-600 dark:text-neutral-300">
                                    {{ $entry->notes ?: '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-neutral-500 dark:text-neutral-400">
                                    Geen uren gevonden.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
