@section('sidebar')
    <flux:navlist class="w-64">
        <flux:navlist.item href="{{ route('dashboards.maintenance') }}" class="mb-4" icon="home">Home</flux:navlist.item>
        <flux:navlist.item href="#" class="mb-4" icon="wrench-screwdriver">Installaties</flux:navlist.item>
        <flux:navlist.item href="#" class="mb-4" icon="wrench">Onderhoud</flux:navlist.item>
        <flux:navlist.item href="{{ route('dashboards.calendar.worker') }}" class="mb-4" icon="calendar-days">Kalender
        </flux:navlist.item>
        <flux:navlist.item href="#" class="mb-4" icon="bell" @click.prevent="openNotificationsDrawer = true">
            Meldingen
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
                Uitloggen
            </flux:navlist.item>
        </form>
    </flux:navlist>
@endsection
