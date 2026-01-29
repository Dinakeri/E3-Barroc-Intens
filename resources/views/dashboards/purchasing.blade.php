<x-layouts.dashboard>
    @section('title', 'Inkoop Dashboard')
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold mb-2 text-left">Inkoop Dashboard</h1>
            <p>Welkom op het Inkoop Dashboard. Hier vindt u een overzicht van inkoop en voorraadbeheer.</p>
        </div>
        
        <!-- Warnings Box -->
        <div class="bg-yellow-500 text-black rounded-lg px-4 py-3 flex items-center gap-3 shadow-lg">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
            <div>
                <div class="font-bold text-sm">Waarschuwingen</div>
                <div class="text-2xl font-bold">{{ $warningsCount ?? 0 }}</div>
            </div>
        </div>
    </div>

    @section('sidebar')
        <x-purchasing-sidebar current="dashboard" />
    @endsection

    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">Openstaande bestellingen:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">45</flux:subheading>
            <flux:text icon="arrow-trending-up" color="green" class="text-sm font-bold">12% gestegen</flux:text>
        </div>

        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">Voorraadwaarde:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">€125,000</flux:subheading>
            <flux:text icon="arrow-trending-up" color="green" class="text-sm font-bold">5% gestegen</flux:text>
        </div>

        <div class="border-2 rounded-xl p-4 my-6">
            <flux:heading size="xl" class="mb-2">Leveranciers:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">23</flux:subheading>
            <flux:text icon="arrow-trending-down" color="red" class="text-sm font-bold">2 nieuwe deze maand</flux:text>
        </div>
    </div>
</x-layouts.dashboard>
