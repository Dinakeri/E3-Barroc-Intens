<x-layouts.dashboard>
    @section('title', 'Onderhoud Dashboard')
    <div>
        <h1 class="text-3xl font-bold mb-6 text-left text-white">Onderhoud Dashboard</h1>
    </div>
    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="{{ route('dashboards.maintenance') }}" class="mb-4" icon="home">Home</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="wrench-screwdriver">Installaties</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="wrench">Onderhoud</flux:navlist.item>
            <flux:navlist.item href="{{ route('maintenance.repairs') }}" class="mb-4" icon="bolt">Storingen</flux:navlist.item>
            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="#" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Uitloggen</flux:navlist.item>
        </flux:navlist>
    @endsection
        <div class="mt-6">
            @if(isset($mailError) && $mailError)
                <div class="p-3 mb-4 bg-red-100 text-red-800 rounded">Fout bij ophalen e-mails: {{ $mailError }}</div>
            @endif

            @if(isset($emails) && $emails && $emails->count())
                <div class="space-y-3">
                    @foreach($emails as $email)
                        <div class="p-3 border rounded bg-neutral-900 text-white">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="font-semibold">{{ $email['subject'] ?? '(geen onderwerp)' }}</div>
                                    <div class="text-sm text-neutral-400">Van: {{ $email['from_name'] ?: $email['from'] }}</div>
                                </div>
                                <div class="text-xs text-neutral-500">{{ optional($email['date'])->format ? optional($email['date'])->format('Y-m-d H:i') : $email['date'] }}</div>
                            </div>
                            <div class="mt-2 text-sm text-neutral-300">{{ Str::limit(strip_tags($email['preview'] ?? ''), 300) }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-3 text-sm text-neutral-400">Geen e-mails gevonden of geen mailbox geconfigureerd.</div>
            @endif
        </div>
    </x-layouts.dashboard>
