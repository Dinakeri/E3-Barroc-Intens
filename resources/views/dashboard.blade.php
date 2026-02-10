<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl" x-data="{ photoOpen: false }" @keydown.escape.window="photoOpen = false">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <div class="flex h-full flex-col justify-between p-4">
                    <div class="flex items-center gap-4">
                        <button type="button" class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full focus:outline-none focus:ring-2 focus:ring-neutral-400" @click="photoOpen = true" aria-label="Profielfoto wijzigen">
                            @php
                                $photoPath = auth()->user()->profile_photo_path;
                                $roleLabels = [
                                    'admin' => 'Beheerder',
                                    'finance' => 'Financiën',
                                    'maintenance' => 'Onderhoud',
                                    'sales' => 'Verkoop',
                                    'purchasing' => 'Inkoop',
                                    'none' => 'Geen',
                                ];
                            @endphp
                            @if ($photoPath)
                                <img class="h-full w-full object-cover" src="{{ \Illuminate\Support\Facades\Storage::url($photoPath) }}" alt="{{ auth()->user()->name }}" />
                            @else
                                <span class="flex h-full w-full items-center justify-center rounded-full bg-neutral-200 text-lg font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            @endif
                        </button>
                        <div class="min-w-0">
                            <div class="truncate text-base font-semibold text-neutral-900 dark:text-neutral-100">{{ auth()->user()->name }}</div>
                            <div class="truncate text-sm text-neutral-500 dark:text-neutral-400">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs font-medium uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Afdeling</span>
                        <span class="rounded-full border border-neutral-300 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-neutral-700 dark:border-neutral-600 dark:text-neutral-300">
                            {{ $roleLabels[auth()->user()->role ?? 'none'] ?? 'Geen' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            @if (auth()->check() && auth()->user()->role === 'admin')
                @php
                    $roles = $users->pluck('role')->map(fn ($role) => $role ?? 'none')->unique()->sort()->values();
                @endphp
                <div class="h-full overflow-auto p-4" x-data="{ search: '', role: 'all', matches(user) { const q = this.search.toLowerCase().trim(); const roleOk = this.role === 'all' || (user.role ?? 'none') === this.role; const nameOk = !q || user.name.toLowerCase().includes(q); return roleOk && nameOk; } }">
                    <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Alle accounts</h2>
                        <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ $users->count() }} totaal</span>
                    </div>

                    <div class="mb-4 flex flex-wrap items-end gap-3">
                        <label class="flex w-full max-w-xs flex-col gap-1 text-xs font-medium uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                            Zoeken
                            <input type="search" x-model="search" placeholder="Zoek gebruikers..." class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm focus:border-neutral-400 focus:outline-none dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100" />
                        </label>
                        <label class="flex w-full max-w-xs flex-col gap-1 text-xs font-medium uppercase tracking-wide text-neutral-500 dark:text-neutral-400">
                            Rol
                            <select x-model="role" class="rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm focus:border-neutral-400 focus:outline-none dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                                <option value="all">Alle rollen</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $roleLabels[$role] ?? ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </label>
                        <a href="{{ route('admin.users.create') }}" class="inline-flex h-10 items-center rounded-lg bg-neutral-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-neutral-800 dark:bg-white dark:text-neutral-900">
                            Aanmaken
                        </a>
                    </div>

                    <ul class="space-y-2">
                        @forelse ($users as $user)
                            <li x-show="matches({ name: @js($user->name), role: @js($user->role ?? 'none') })" class="flex flex-wrap items-center justify-between gap-2 rounded-lg border border-neutral-200 bg-white px-3 py-2 text-sm text-neutral-900 shadow-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                                <div class="min-w-0">
                                    <div class="font-medium">{{ $user->name }}</div>
                                    <div class="truncate text-neutral-500 dark:text-neutral-400">{{ $user->email }}</div>
                                </div>
                                <span class="rounded-full border border-neutral-300 px-2 py-0.5 text-xs font-medium uppercase tracking-wide text-neutral-700 dark:border-neutral-600 dark:text-neutral-300">
                                    {{ $roleLabels[$user->role ?? 'none'] ?? 'Geen' }}
                                </span>
                            </li>
                        @empty
                            <li class="rounded-lg border border-dashed border-neutral-300 px-3 py-6 text-center text-sm text-neutral-500 dark:border-neutral-700 dark:text-neutral-400">
                                Geen accounts gevonden.
                            </li>
                        @endforelse
                    </ul>
                </div>
            @elseif (auth()->check() && auth()->user()->role === 'maintenance')
                <div class="h-full overflow-auto p-4">
                    <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                        <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Nieuwe e-mails</h2>
                        <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ ($newEmails ?? collect())->count() }} nieuw</span>
                    </div>

                    @if (!empty($mailError))
                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-200">
                            {{ $mailError }}
                        </div>
                    @endif

                    <div class="mb-4 flex items-center justify-end">
                        <a href="{{ route('maintenance.repairs') }}" class="inline-flex h-10 items-center rounded-lg bg-neutral-900 px-4 text-sm font-semibold text-white shadow-sm hover:bg-neutral-800 dark:bg-white dark:text-neutral-900">
                            Bekijk reparatie-inbox
                        </a>
                    </div>

                    <ul class="space-y-2">
                        @forelse (($newEmails ?? collect()) as $email)
                            <li class="rounded-lg border border-neutral-200 bg-white px-3 py-3 text-sm text-neutral-900 shadow-sm dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-100">
                                <div class="flex flex-wrap items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <div class="font-medium">{{ $email['subject'] ?: '(geen onderwerp)' }}</div>
                                        <div class="truncate text-neutral-500 dark:text-neutral-400">
                                            Van: {{ $email['from_name'] ?: $email['from'] }}
                                        </div>
                                    </div>
                                    <span class="rounded-full border border-emerald-300 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:border-emerald-600 dark:text-emerald-300">
                                        Nieuw
                                    </span>
                                </div>
                                <div class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($email['preview'] ?? ''), 160) }}
                                </div>
                            </li>
                        @empty
                            <li class="rounded-lg border border-dashed border-neutral-300 px-3 py-6 text-center text-sm text-neutral-500 dark:border-neutral-700 dark:text-neutral-400">
                                Geen nieuwe e-mails.
                            </li>
                        @endforelse
                    </ul>
                </div>
            @else
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            @endif
        </div>

        <div x-show="photoOpen" x-cloak class="fixed inset-0 z-[999999] flex items-center justify-center">
            <div class="absolute inset-0 bg-black/50" @click="photoOpen = false"></div>
            <div class="relative w-full max-w-md rounded-xl border border-neutral-200 bg-white p-6 shadow-lg dark:border-neutral-700 dark:bg-neutral-900">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Profielfoto uploaden</h3>
                    <button type="button" class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400" @click="photoOpen = false">✕</button>
                </div>

                <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="file" name="photo" accept="image/*" required class="block w-full text-sm text-neutral-600 file:mr-3 file:rounded-lg file:border-0 file:bg-neutral-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-neutral-800 dark:text-neutral-300 dark:file:bg-white dark:file:text-neutral-900" />
                    <div class="flex justify-end gap-2">
                        <button type="button" class="rounded-lg border border-neutral-300 px-3 py-2 text-sm font-medium text-neutral-700 hover:border-neutral-400 dark:border-neutral-700 dark:text-neutral-200" @click="photoOpen = false">Annuleren</button>
                        <button type="submit" class="rounded-lg bg-neutral-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-neutral-800 dark:bg-white dark:text-neutral-900">Opslaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
