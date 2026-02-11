<flux:navlist class="w-64">
    <flux:navlist.item href="{{ route('dashboard') }}" class="mb-4" icon="home">Home</flux:navlist.item>
    <flux:navlist.item href="{{ route('contracts.index') }}" class="mb-4" icon="document-duplicate">Contracten
    </flux:navlist.item>
    <flux:navlist.item href="{{ route('contracts.create') }}" class="mb-4" icon="plus">Nieuw contract
    </flux:navlist.item>
    <flux:navlist.item href="{{ route('invoices.index') }}" class="mb-4" icon="document-text">Facturen
    </flux:navlist.item>
    <flux:navlist.item href="{{ route('invoices.create') }}" class="mb-4" icon="plus">Maak factuur
    </flux:navlist.item>
    <flux:navlist.item href="{{ route('payments.index') }}" class="mb-4" icon="currency-euro">Betalingen
    </flux:navlist.item>
    <flux:navlist.item href="{{ route('payments.create') }}" class="mb-4" icon="plus">Registreer betaling
    </flux:navlist.item>
    <flux:navlist.item href="#" class="mb-4" icon="chevron-double-right" @click.prevent="openBkrDrawer = true">
        Voer een BKR-check</flux:navlist.item>
    <flux:navlist.item href="#" class="mb-4" icon="bell" @click.prevent="openNotificationsDrawer = true">Meldingen
        @php $count = auth()->user()->unreadNotifications->count(); @endphp
        @if($count > 0)
            <flux:badge size="sm" color="red">{{ $count }}</flux:badge>
        @endif
    </flux:navlist.item>

    <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
    <flux:navlist.item href="{{ route('dashboard') }}" class="mb-4" icon="home">Dashboard</flux:navlist.item>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <flux:navlist.item as="button" type="submit" class="mb-4 mt-auto w-full text-left" icon="arrow-left-end-on-rectangle">
            Log Out
        </flux:navlist.item>
    </form>
</flux:navlist>
