@props(['current' => ''])

<flux:navlist class="w-64">
    <flux:navlist.item 
        href="{{ route('dashboards.purchasing') }}" 
        class="mb-4" 
        icon="home"
        :current="$current === 'dashboard'">
        Startpagina
    </flux:navlist.item>
    
    <flux:navlist.item 
        href="#" 
        class="mb-4" 
        icon="shopping-cart"
        :current="$current === 'orders'">
        Bestellingen
    </flux:navlist.item>
    
    <flux:navlist.item 
        href="{{ route('products.index') }}" 
        class="mb-4" 
        icon="cube"
        :current="$current === 'products'">
        Voorraad
    </flux:navlist.item>
    
    <flux:navlist.item 
        href="#" 
        class="mb-4" 
        icon="users"
        :current="$current === 'suppliers'">
        Leveranciers
    </flux:navlist.item>
    
    <flux:navlist.item 
        href="#" 
        class="mb-4" 
        icon="chart-bar"
        :current="$current === 'reports'">
        Rapporten
    </flux:navlist.item>

    <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
    
    <flux:navlist.item href="{{ route('dashboard') }}" class="mb-4" icon="home">Dashboard</flux:navlist.item>
    
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <flux:navlist.item 
            as="button" 
            type="submit" 
            class="mb-4 mt-auto w-full text-left" 
            icon="arrow-left-end-on-rectangle">
            Afmelden
        </flux:navlist.item>
    </form>
</flux:navlist>
