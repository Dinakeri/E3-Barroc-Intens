<x-layouts.dashboard>
    @section('title', 'Onderdelen')

    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-2">Onderdelen</h1>
            <p class="text-gray-400">Overzicht van onderdelen en voorraad</p>
        </div>
        <flux:button href="{{ route('parts.create') }}" variant="primary">
            Nieuw onderdeel
        </flux:button>
    </div>

    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-zinc-700 text-sm text-gray-500">
                        <th class="px-4 py-3">Onderdeel</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Voorraad</th>
                        <th class="px-4 py-3">Min</th>
                        <th class="px-4 py-3">Locatie</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700 text-sm">
                    @forelse($parts as $part)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-900">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $part->name }}</div>
                                <p class="text-xs text-gray-500 dark:text-zinc-300 line-clamp-1">{{ $part->description }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $part->sku }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $part->stock }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $part->min_stock }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-zinc-200">{{ $part->location ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <flux:badge color="{{ $part->status === 'out_of_stock' ? 'red' : ($part->status === 'phased_out' ? 'zinc' : 'green') }}">
                                    {{ $part->status === 'out_of_stock' ? 'Niet op voorraad' : ($part->status === 'phased_out' ? 'Uitgefaseerd' : 'Actief') }}
                                </flux:badge>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <flux:button size="sm" variant="ghost" href="{{ route('parts.edit', $part) }}">
                                        Bewerken
                                    </flux:button>
                                    <form action="{{ route('parts.destroy', $part) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit onderdeel wilt verwijderen?')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button size="sm" variant="ghost" type="submit">
                                            Verwijderen
                                        </flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-zinc-300">
                                Geen onderdelen gevonden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $parts->links() }}
        </div>
    </div>

    @section('sidebar')
        <x-purchasing-sidebar current="parts" />
    @endsection
</x-layouts.dashboard>
