<x-layouts.dashboard>
    @section('title', 'Onderhoud Dashboard')
    <div>
        <h1 class="text-3xl font-bold mb-6 text-left text-white">Onderhoud Dashboard</h1>
    </div>

    @section('sidebar')
        @include('partials.maintenanceSidebar')
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

        .fc-theme-standard td,
        .fc-theme-standard th {
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

        /* Modal z-index fix */
        #eventModal {
            z-index: 9999 !important;
        }

        #eventModal>div {
            position: relative;
            z-index: 10000;
        }
    </style>

    <div>
        <h1 class="text-3xl font-bold mb-6 text-left text-white">Mijn Kalender</h1>
    </div>

    <!-- Event Detail Modal -->
    <div id="eventModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-neutral-800 rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 id="eventTitle" class="text-xl font-bold text-white"></h2>
                <button onclick="closeEventModal()" class="text-neutral-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-neutral-300 mb-1">Datum & Tijd</label>
                    <div id="eventDateTime" class="text-white"></div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-300 mb-1">Klant</label>
                    <div id="eventCustomer" class="text-white"></div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-300 mb-1">Notities</label>
                    <div id="eventNotes" class="text-neutral-300 whitespace-pre-wrap"></div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button onclick="closeEventModal()"
                        class="flex-1 px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded transition">
                        Sluiten
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <div id="calendar"></div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        function initializeCalendar() {
            var calendarEl = document.getElementById('calendar');
            // Clear any existing calendar instance
            if (calendarEl._calendar) {
                calendarEl._calendar.destroy();
            }
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
                    @foreach ($maintenances as $maintenance)
                        {
                            title: {!! json_encode($maintenance->Title) !!},
                            start: {!! json_encode($maintenance->Date) !!},
                            color: '#10b981',
                            extendedProps: {
                                content: {!! json_encode($maintenance->Content) !!}
                            }
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    // Parse content to extract customer and notes
                    const content = info.event.extendedProps.content || '';
                    const lines = content.split('\n');
                    let customer = '';
                    let notes = '';

                    if (lines[0] && lines[0].startsWith('Van: ')) {
                        customer = lines[0].replace('Van: ', '');
                        notes = lines.slice(2).join('\n').trim();
                    } else {
                        notes = content;
                    }

                    // Format date/time
                    const dateTime = info.event.start.toLocaleString('nl-NL', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // Populate modal
                    document.getElementById('eventTitle').textContent = info.event.title;
                    document.getElementById('eventDateTime').textContent = dateTime;
                    document.getElementById('eventCustomer').textContent = customer || '(Onbekend)';
                    document.getElementById('eventNotes').textContent = notes || '(Geen notities)';

                    // Show modal
                    document.getElementById('eventModal').classList.remove('hidden');
                },
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                height: 'auto'
            });
            calendarEl._calendar = calendar;
            calendar.render();
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', initializeCalendar);

        // Initialize when navigating via Livewire
        document.addEventListener('livewire:navigated', initializeCalendar);

        function closeEventModal() {
            document.getElementById('eventModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('eventModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEventModal();
            }
        });
    </script>
    </x-layouts.dashb>
