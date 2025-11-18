<flux:navlist class="w-64">
    <flux:navlist.item href="{{ route('dashboard') }}" class="mb-4" icon="home">Home</flux:navlist.item>
    <flux:navlist.item href="{{ route('dashboards.contracts') }}" class="mb-4" icon="building-storefront">Contracten</flux:navlist.item>
    <flux:navlist.item href="{{ route('invoices.index') }}" class="mb-4" icon="building-storefront">Facturen</flux:navlist.item>
    <flux:navlist.item href="{{ route('invoices.create') }}" class="mb-4" icon="plus">Maak factuur</flux:navlist.item>
    <flux:navlist.item href="#" class="mb-4" icon="building-storefront">Betalingen</flux:navlist.item>
    <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
    <flux:navlist.item href="#" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Logout</flux:navlist.item>
</flux:navlist>
