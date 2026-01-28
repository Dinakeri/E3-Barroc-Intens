<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Navigatie')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:navlist.item as="button" type="submit" icon="arrow-left-end-on-rectangle" class="w-full text-left">
                            {{ __('Log Uit') }}
                        </flux:navlist.item>
                    </form>
                </flux:navlist.group>
                @php
                    $user = auth()->user();
                @endphp

                @if($user->role === 'maintenance' || $user->role === 'admin')
                    <flux:navlist.group :heading="__('Onderhoud')" class="grid">
                        <flux:navlist.item icon="wrench-screwdriver" :href="route('dashboards.maintenance')" :current="request()->routeIs('dashboards.maintenance')" wire:navigate>
                            {{ __('Onderhoud Home') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="wrench" :href="route('maintenance.calendar')" :current="request()->routeIs('maintenance.calendar')" wire:navigate>
                            {{ __('Kalender') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="bolt" :href="route('maintenance.repairs')" :current="request()->routeIs('maintenance.repairs')" wire:navigate>
                            {{ __('Storingen') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if($user->role === 'sales' || $user->role === 'admin')
                    <flux:navlist.group :heading="__('Sales')" class="grid">
                        <flux:navlist.item icon="chart-bar" :href="route('dashboards.sales')" :current="request()->routeIs('dashboards.sales')" wire:navigate>
                            {{ __('Sales Dashboard') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="users" :href="route('customers.index')" :current="request()->routeIs('customers.*')" wire:navigate>
                            {{ __('Klanten') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="shopping-cart" :href="route('products')" :current="request()->routeIs('products')" wire:navigate>
                            {{ __('Bestellingen') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if($user->role === 'finance' || $user->role === 'admin')
                    <flux:navlist.group :heading="__('Finance')" class="grid">
                        <flux:navlist.item icon="banknotes" :href="route('dashboards.finance')" :current="request()->routeIs('dashboards.finance')" wire:navigate>
                            {{ __('Finance Dashboard') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="wallet" :href="route('dashboards.invoices')" :current="request()->routeIs('dashboards.invoices')" wire:navigate>
                            {{ __('Facturen') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="receipt-percent" :href="route('payments.index')" :current="request()->routeIs('payments.*')" wire:navigate>
                            {{ __('Uitgaven') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if($user->role === 'purchasing' || $user->role === 'admin')
                    <flux:navlist.group :heading="__('Inkoop')" class="grid">
                        <flux:navlist.item icon="shopping-bag" :href="route('dashboards.purchasing')" :current="request()->routeIs('dashboards.purchasing')" wire:navigate>
                            {{ __('Inkoop Dashboard') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-2 py-1 text-sm">
                            <span class="i-lucide-arrow-right-start-on-rectangle"></span>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        @if(session('error'))
            <div id="error-message" class="m-4 p-4 bg-red-600 border-2 border-red-800 text-white rounded-lg shadow-lg font-bold">
                <div class="flex items-center justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="document.getElementById('error-message').remove()" class="ml-4 text-white hover:text-red-200">
                        ✕
                    </button>
                </div>
            </div>
        @endif

        {{ $slot }}

        @fluxScripts
    </body>
</html>
