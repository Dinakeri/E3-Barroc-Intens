<x-layouts.dashboard>
    @section('title', 'Onderhoud Kalender')

    @section('sidebar')
        <flux:navlist class="w-64">
            <flux:navlist.item href="{{ route('dashboards.maintenance') }}" class="mb-4" icon="home">Home</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="wrench-screwdriver">Installaties</flux:navlist.item>
            <flux:navlist.item href="#" class="mb-4" icon="wrench">Onderhoud</flux:navlist.item>
            <flux:navlist.item href="{{ route('maintenance.repairs') }}" class="mb-4" icon="bolt">Storingen</flux:navlist.item>
            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="#" class="mb-4 mt-auto" icon="arrow-left-end-on-rectangle">Uitloggen</flux:navlist.item>
        </flux:navlist>
    @endsection

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
    <style>
        #calendar {
            background: #27272a;
            padding: 20px;
            border-radius: 8px;
            min-height: 600px;
        }
        .fc {
            color: #e4e4e7;
        }
        .fc .fc-toolbar-title {
            color: #e4e4e7;
        }
        .fc .fc-button {
            background: #3f3f46;
            border-color: #52525b;
            color: #e4e4e7;
        }
        .fc .fc-button:hover {
            background: #52525b;
        }
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: #3b82f6;
            border-color: #3b82f6;
        }
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: #3f3f46;
        }
        .fc-theme-standard .fc-scrollgrid {
            border-color: #3f3f46;
        }
        .fc .fc-daygrid-day-number {
            color: #e4e4e7;
        }
        .fc .fc-col-header-cell {
            background: #18181b;
            color: #e4e4e7;
        }
        .fc .fc-daygrid-day.fc-day-today {
            background: #1e293b;
        }
    </style>

    <div>
        <h1 class="text-3xl font-bold mb-6 text-left text-white">Onderhoud Kalender</h1>
    </div>

    <div class="mt-6">
        <div id="calendar"></div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'nl',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Vandaag',
                    month: 'Maand',
                    week: 'Week',
                    day: 'Dag'
                },
                events: [
                    @foreach($maintenances as $maintenance)
                    {
                        title: {!! json_encode($maintenance->Title) !!},
                        start: {!! json_encode($maintenance->Date) !!},
                        color: '#3b82f6',
                        extendedProps: {
                            content: {!! json_encode($maintenance->Content) !!}
                        }
                    },
                    @endforeach
                ],
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                height: 'auto'
            });
            calendar.render();
        });
    </script>
</x-layouts.dashboard>
