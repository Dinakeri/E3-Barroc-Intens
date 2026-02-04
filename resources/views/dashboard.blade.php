<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="h-full overflow-auto p-4">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">All accounts</h2>
                    <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ $users->count() }} total</span>
                </div>

                <ul class="space-y-2">
                    @forelse ($users as $user)
                        <li class="flex flex-wrap items-center justify-between gap-2 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                            <div class="min-w-0">
                                <div class="font-medium">{{ $user->name }}</div>
                                <div class="truncate text-neutral-500 dark:text-neutral-400">{{ $user->email }}</div>
                            </div>
                            <span class="rounded-full border border-neutral-300 px-2 py-0.5 text-xs font-medium uppercase tracking-wide text-neutral-700 dark:border-neutral-600 dark:text-neutral-300">
                                {{ $user->role ?? 'none' }}
                            </span>
                        </li>
                    @empty
                        <li class="rounded-lg border border-dashed border-neutral-300 px-3 py-6 text-center text-sm text-neutral-500 dark:border-neutral-700 dark:text-neutral-400">
                            No accounts found.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
