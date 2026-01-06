<x-layouts.dashboard :title="'Finance Dashboard - nieuwe bestelling'">
    @section('title', 'Finance Dashboard')
    @section('sidebar')
        @include('partials.financeSidebar')
    @endsection

    <div class="mb-8">
        <flux:heading size="xl">Nieuw contract</flux:heading>
        <flux:text class="text-zinc-500">
            Vul de gegevens in om een nieuw contract aan te maken.
        </flux:text>
    </div>

    @include('contracts._form')

</x-layouts.dashboard>
