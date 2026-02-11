<x-layouts.app :title="'Meldingen'">

    <div class="w-full">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Meldingen</h2>
                <p class="text-sm text-gray-400">Beheer en bekijk je recente meldingen</p>
            </div>

            <div class="flex items-center gap-6">
                @php
                    $total = auth()->user()->notifications->count();
                    $unread = auth()->user()->unreadNotifications->count();
                @endphp

                <div class="text-right">
                    <div class="text-xs text-gray-400">Ongelezen</div>
                    <div class="text-lg font-semibold text-red-600">{{ $unread }}</div>
                </div>

                <div class="text-right">
                    <div class="text-xs text-gray-400">Totaal</div>
                    <div class="text-lg font-semibold text-white">{{ $total }}</div>
                </div>

                <form method="POST" action="{{ route('notifications.markAllRead') }}">
                    @csrf
                    <flux:button type="submit" variant="primary">Alles gelezen</flux:button>
                </form>
            </div>
        </div>

        <div
            class="bg-white dark:bg-zinc-900 rounded-lg shadow border border-gray-200 dark:border-zinc-700 overflow-hidden">
            <div
                class="px-6 py-4 border-b border-gray-200 dark:border-zinc-700 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <flux:button href="{{ route('notifications.index', ['filter' => 'all']) }}"
                        :variant="request('filter') === 'all' || !request('filter') ? 'primary' : 'ghost'"
                        size="sm">
                        Alle
                    </flux:button>
                    <flux:button href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                        :variant="request('filter') === 'unread' ? 'primary' : 'ghost'" size="sm">
                        Ongelezen
                    </flux:button>
                    <flux:button href="{{ route('notifications.index', ['filter' => 'read']) }}"
                        :variant="request('filter') === 'read' ? 'primary' : 'ghost'" size="sm">
                        Gelezen
                    </flux:button>
                </div>

                <form method="GET" action="{{ route('notifications.index') }}" class="flex items-center gap-2">
                    <flux:input name="q" type="search" placeholder="Zoeken..." />
                </form>
            </div>

            @php
                $notifications = $notifications ?? auth()->user()->notifications()->latest()->get();
            @endphp

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Bericht</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Ontvangen
                            </th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Status</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Acties</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($notifications as $notification)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition">
                                <td class="px-6 py-4">
                                    <div class="text-gray-900 dark:text-gray-100 truncate">
                                        {{ $notification->data['message'] ?? 'Geen bericht' }}</div>
                                    @if (!empty($notification->data['excerpt']))
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate mt-1">
                                            {{ $notification->data['excerpt'] }}</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-700 dark:text-gray-300">
                                        {{ $notification->created_at->format('d-m-Y H:i') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $notification->created_at->diffForHumans() }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (is_null($notification->read_at))
                                        <flux:badge color="red" size="sm">Ongelezen</flux:badge>
                                    @else
                                        <flux:badge color="green" size="sm">Gelezen</flux:badge>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if (is_null($notification->read_at))
                                            <form method="POST"
                                                action="{{ route('notifications.markRead', $notification->id) }}"
                                                class="inline">
                                                @csrf
                                                <flux:button type="submit" size="sm" variant="primary"
                                                    color="green">
                                                    <flux:icon.eye class="size-4" />
                                                </flux:button>
                                            </form>
                                        @else
                                            <form method="POST"
                                                action="{{ route('notifications.markUnread', $notification->id) }}"
                                                class="inline">
                                                @csrf
                                                <flux:button type="submit" size="sm" variant="primary"
                                                    color="red">
                                                    <flux:icon.eye-slash class="size-4" />
                                                </flux:button>
                                            </form>
                                        @endif

                                        <flux:button href="{{ $notification->data['url'] ?? '#' }}" size="sm"
                                            variant="ghost">
                                            <flux:icon.arrow-top-right-on-square class="size-4" />
                                        </flux:button>

                                        <form method="POST"
                                            action="{{ route('notifications.destroy', $notification->id) }}"
                                            class="inline" onsubmit="return confirm('Deze melding verwijderen?')">
                                            @csrf
                                            @method('DELETE')
                                            <flux:button type="submit" size="sm" variant="danger">
                                                <flux:icon.trash class="size-4" />
                                            </flux:button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">Geen
                                    meldingen gevonden.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800">
                {{-- If using paginator, show links: --}}
                @if (isset($notifications) && $notifications instanceof \Illuminate\Contracts\Pagination\Paginator)
                    {{ $notifications->links() }}
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
