<flux:navlist class="w-64">
    <flux:navlist.item href="{{ route('dashboards.sales') }}" class="mb-4" icon="home">Home</flux:navlist.item>
    <flux:navlist.item href="{{ route('orders.index') }}" class="mb-4" icon="building-storefront">Bestellingen
    </flux:navlist.item>
    <flux:navlist.item href="{{ route('products') }}" class="mb-4" icon="currency-dollar">Producten</flux:navlist.item>
    <flux:navlist.item href="{{ route('customers.index') }}" class="mb-4" icon="user">Klanten</flux:navlist.item>
    <flux:navlist.item href="{{ route('quotes.index') }}" class="mb-4" icon="document-text">Offertes
    </flux:navlist.item>
    <flux:navlist.item href="" class="mb-4" icon="cog">Instellingen</flux:navlist.item>
    <flux:navlist.item href="{{ route('customers.create') }}" class="mb-4" icon="plus">Nieuwe klant toevoegen
    </flux:navlist.item>
    <flux:navlist.item href="#" class="mb-4" icon="bell" @click.prevent="openNotificationsDrawer = true">Meldingen
        @php $count = auth()->user()->unreadNotifications->count(); @endphp
        @if ($count > 0)
            <flux:badge size="sm" color="red">{{ $count }}</flux:badge>
        @endif
    </flux:navlist.item>

    <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
    <flux:navlist.item href="{{ route('dashboard') }}" class="mb-4" icon="arrow-left">Dashboard</flux:navlist.item>
    <form action="{{ route('logout') }}" method="POST">
        <flux:navlist.item class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Afmelden</flux:navlist.item>
    </form>

</flux:navlist>
