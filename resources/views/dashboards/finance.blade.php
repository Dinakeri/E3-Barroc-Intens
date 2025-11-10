<x-layouts.dashboard title="Finance Dashboard">
    <div class="contracts">
        <h2 class="text-2xl font-bold mb-4">Actieve Contracten</h2>

        <div class="flex items-center gap-4 mb-4">
            <div class="text-4xl font-semibold" data-test="contracts-count">{{ \App\Models\Contract::count() }}</div>
        </div>

        <div>
            <a href="{{ route('dashboards.contracts') }}" class="text-sm text-primary-600 hover:underline" data-test="contracts-link">Bekijk alles</a>
        </div>
    </div>
</x-layouts.dashboard>
