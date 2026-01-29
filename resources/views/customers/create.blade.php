<x-layouts.dashboard>
    @section('title', 'Sales Dashboard')
    <div class="flex justify-between">
        <div>
            <h1 class="text-3xl font-bold mb-6 text-left">Add New Customer</h1>
        </div>
        <div class="">
            <flux:button href="{{ route('customers.index') }}" variant="primary" color="blue" icon="chevron-left" class="ml-auto">Back</flux:button>
        </div>
    </div>



    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    {{-- Assuming you have installed Flux UI and included @fluxAppearance & @fluxScripts in your layout. :contentReference[oaicite:1]{index=1} --}}
    <div class="min-h-screen p-6">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            @include('customers._form')
        </form>
    </div>

</x-layouts.dashboard>
