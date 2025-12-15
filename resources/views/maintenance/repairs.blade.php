<x-layouts.dashboard>
    @section('title', 'Onderhoud Dashboard')
    <div>
        <h1 class="text-3xl font-bold mb-6 text-left text-white">Onderhoud Dashboard</h1>
    </div>
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
        <div class="mt-6">
            @if(isset($mailError) && $mailError)
                <div class="p-3 mb-4 bg-red-100 text-red-800 rounded">Fout bij ophalen e-mails: {{ $mailError }}</div>
            @endif

            @if(isset($emails) && $emails && $emails->count())
                <div class="space-y-3">
                    @foreach($emails as $email)
                        <div class="p-3 border rounded bg-neutral-900 text-white">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="font-semibold">{{ $email['subject'] ?? '(geen onderwerp)' }}</div>
                                    <div class="text-sm text-neutral-400">Van: {{ $email['from_name'] ?: $email['from'] }}</div>
                                </div>
                                <div class="flex items-center gap-3">
                                            <button
                                                data-id="{{ $email['id'] ?? '' }}"
                                                data-subject="{{ $email['subject'] ?? '' }}"
                                                data-from="{{ $email['from'] ?? '' }}"
                                                data-from-name="{{ $email['from_name'] ?? '' }}"
                                                data-scheduled="{{ ($email['scheduled'] ?? false) ? 1 : 0 }}"
                                                onclick="openPlanModal({ id: this.dataset.id, subject: this.dataset.subject, from: this.dataset.from, from_name: this.dataset.fromName, scheduled: this.dataset.scheduled === '1' })"
                                            class="px-3 py-1 {{ $email['scheduled'] ? 'bg-amber-600 hover:bg-amber-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white text-sm rounded transition">
                                         {{ $email['scheduled'] ? 'Opnieuw plannen' : 'Plan' }}
                                    </button>
                                     @if(!empty($email['scheduled']) && !empty($email['scheduled_at']))
                                         <div class="text-xs text-neutral-400 mt-1">Ingepland op: {{ $email['scheduled_at'] }}</div>
                                     @endif
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-neutral-300">{{ Str::limit(strip_tags($email['preview'] ?? ''), 300) }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-3 text-sm text-neutral-400">Geen e-mails gevonden of geen mailbox geconfigureerd.</div>
            @endif

            <!-- Planning Modal -->
            <div id="planModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-neutral-800 rounded-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-white">Reparatie Plannen</h2>
                        <button onclick="closePlanModal()" class="text-neutral-400 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-300 mb-1">Onderwerp</label>
                            <div id="modalSubject" class="text-white font-semibold"></div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-300 mb-1">Van</label>
                            <div id="modalFrom" class="text-neutral-400"></div>
                        </div>

                        <div>
                            <label for="repairDate" class="block text-sm font-medium text-neutral-300 mb-1">Datum</label>
                            <input type="date" id="repairDate"
                                   class="w-full px-3 py-2 bg-neutral-700 border border-neutral-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="repairTime" class="block text-sm font-medium text-neutral-300 mb-1">Tijd</label>
                            <input type="time" id="repairTime"
                                   class="w-full px-3 py-2 bg-neutral-700 border border-neutral-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="repairNotes" class="block text-sm font-medium text-neutral-300 mb-1">Notities</label>
                            <textarea id="repairNotes" rows="3"
                                      class="w-full px-3 py-2 bg-neutral-700 border border-neutral-600 rounded text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Extra informatie over de reparatie..."></textarea>
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button onclick="savePlanRepair()"
                                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                                Opslaan
                            </button>
                            <button onclick="closePlanModal()"
                                    class="flex-1 px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-white rounded transition">
                                Annuleren
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                let currentEmail = null;

                function openPlanModal(email) {
                    currentEmail = email;
                    document.getElementById('modalSubject').textContent = email.subject || '(geen onderwerp)';
                    document.getElementById('modalFrom').textContent = email.from_name || email.from;

                    // Set default date to today and time to 09:00
                    const today = new Date().toISOString().split('T')[0];
                    document.getElementById('repairDate').value = today;
                    document.getElementById('repairTime').value = '09:00';
                    document.getElementById('repairNotes').value = '';

                    document.getElementById('planModal').classList.remove('hidden');
                }

                function closePlanModal() {
                    document.getElementById('planModal').classList.add('hidden');
                    currentEmail = null;
                }

                function savePlanRepair() {
                    const date = document.getElementById('repairDate').value;
                    const time = document.getElementById('repairTime').value;
                    const notes = document.getElementById('repairNotes').value;

                    if (!date || !time) {
                        alert('Vul een datum en tijd in');
                        return;
                    }

                    // Prepare data to send - only include fields that have values
                    const repairData = {
                        email_id: currentEmail.id || '',
                        from: currentEmail.from || '',
                        date: date,
                        time: time,
                        _token: '{{ csrf_token() }}'
                    };

                    // Only add optional fields if they have values
                    if (currentEmail.subject) {
                        repairData.subject = currentEmail.subject;
                    }
                    if (currentEmail.from_name) {
                        repairData.from_name = currentEmail.from_name;
                    }
                    if (notes) {
                        repairData.notes = notes;
                    }

                    // Send to backend
                    fetch('/maintenance/repairs/schedule', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(repairData)
                    })
                    .then(async (response) => {
                        let data;
                        try {
                            data = await response.json();
                        } catch (e) {
                            // Fallback when server returned HTML error page
                            const text = await response.text();
                            throw new Error('Server error: ' + (text.slice(0, 200) || 'Unknown'));
                        }
                        return data;
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Reparatie succesvol ingepland!');
                            closePlanModal();
                            // Optionally reload the page or update the UI
                        } else {
                            alert('Er is een fout opgetreden: ' + (data.message || 'Onbekende fout'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Er is een fout opgetreden bij het opslaan');
                    });
                }

                // Close modal when clicking outside
                document.getElementById('planModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closePlanModal();
                    }
                });
            </script>
        </div>
    </x-layouts.dashboard>
