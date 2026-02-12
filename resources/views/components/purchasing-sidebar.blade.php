@props(['current' => ''])

<flux:navlist class="w-64">
    <flux:navlist.item href="{{ route('dashboards.purchasing') }}" class="mb-4" icon="home"
        :current="$current === 'dashboard'">
        Startpagina
    </flux:navlist.item>
    
    <flux:navlist.item 
        href="{{ route('purchases.index') }}" 
        class="mb-4" 
        icon="shopping-cart"
        :current="$current === 'purchases'">
        Bestellingen
    </flux:navlist.item>

    <flux:navlist.item href="{{ route('products.index') }}" class="mb-4" icon="cube"
        :current="$current === 'products'">
        Producten
    </flux:navlist.item>

    <flux:navlist.item 
        href="{{ route('parts.index') }}" 
        class="mb-4" 
        icon="squares-plus"
        :current="$current === 'parts'">
        Onderdelen
    </flux:navlist.item>

    <flux:navlist.item href="#" class="mb-4" icon="users" :current="$current === 'suppliers'">
        Leveranciers
    </flux:navlist.item>

    <flux:navlist.item href="#" class="mb-4" icon="chart-bar" :current="$current === 'reports'">
        Rapporten
    </flux:navlist.item>

    <flux:navlist.item href="#" class="mb-4" icon="bell" @click.prevent="openNotificationsDrawer = true">Meldingen
        @php $count = auth()->user()->unreadNotifications->count(); @endphp
        @if ($count > 0)
            <flux:badge size="sm" color="red">{{ $count }}</flux:badge>
        @endif
    </flux:navlist.item>

    <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>

    <flux:navlist.item href="{{ route('dashboard') }}" class="mb-4" icon="home">Dashboard</flux:navlist.item>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <flux:navlist.item as="button" type="submit" class="mb-4 mt-auto w-full text-left"
            icon="arrow-left-end-on-rectangle">
            Afmelden
        </flux:navlist.item>
    </form>
</flux:navlist>
