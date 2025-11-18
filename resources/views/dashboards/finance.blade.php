<x-layouts.dashboard>
    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Financien Dashboard</h1>
        <p>Welcome bij het Financien Dashboard. hier kan je een overzicht vinden van de financiële statistieken en prestaties.</p>
    </div>

    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    <div class="contracts">
        <h2 class="text-2xl font-bold mb-4">Actieve Contracten</h2>

        <div class="flex items-center gap-4 mb-4">
            <div class="text-4xl font-semibold" data-test="contracts-count">{{ \App\Models\Contract::count() }}</div>
        </div>
    </div>

</x-layouts.dashboard>
