<div class="relative w-full">
    <div class="max-w-sm md:max-w-md bg-white dark:bg-zinc-900 shadow-lg border border-gray-200 dark:border-zinc-700 rounded-lg overflow-hidden">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-zinc-800 border-b border-gray-100 dark:border-zinc-700">
            <div class="flex items-center space-x-3">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Meldingen</h3>
                @php $count = auth()->user()->unreadNotifications->count(); @endphp
                @if($count > 0)
                    <flux:badge size="sm" color="red">{{ $count }}</flux:badge>
                @endif
            </div>

            <div class="flex items-center space-x-2">
                <flux:button variant="ghost" size="sm" class="text-xs">Alles gelezen</flux:button>
                <flux:button variant="ghost" size="sm" @click="openNotificationsDrawer = false" aria-label="Meldingen sluiten">
                    <flux:icon.x-mark />
                </flux:button>
            </div>
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse (auth()->user()->unreadNotifications as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-zinc-800 border-b border-gray-100 dark:border-zinc-700">
                    <div class="flex-shrink-0 mt-1">
                        <div class="h-9 w-9 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-400">
                            <flux:icon.bell class="size-5" />
                        </div>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm text-gray-800 dark:text-gray-100 truncate">{{ $notification->data['message'] }}</p>
                        <div class="mt-1 flex items-center text-xs text-gray-500 dark:text-gray-400">
                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                            @if(!empty($notification->data['source']))
                                <span class="mx-2">•</span>
                                <span class="truncate">{{ $notification->data['source'] }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                    <flux:icon.inbox class="mx-auto size-10 mb-3 opacity-50" />
                    <p class="text-sm">Je bent helemaal bijgewerkt — geen nieuwe meldingen.</p>
                </div>
            @endforelse
        </div>

        <div class="px-4 py-3 bg-gray-50 dark:bg-zinc-800 border-t border-gray-100 dark:border-zinc-700 text-center">
            <flux:link href="/notifications" class="text-sm">Alle meldingen bekijken</flux:link>
        </div>
    </div>
</div>
