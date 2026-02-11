<x-layouts.dashboard>
    @include('partials.sectionSalesTitle')
    <div class="">
        <h1 class="text-3xl font-bold mb-6 text-left">Verkoopsdashboard</h1>
        <p>Welkom op het Verkoopsdashboard. Hier vindt u een overzicht van verkoopsgegevens en prestaties.</p>
    </div>


    @section('sidebar')
        @include('partials.salesSidebar')
    @endsection

    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="border-2 rounded-lg p-4 my-6">
            <flux:heading>Totaal Orders</flux:heading>
            <flux:subheading class="text-2xl font-bold text-blue-500">{{ $totalOrders }}</flux:subheading>
        </div>

        <div class="border-2 rounded-lg p-4 my-6">
            <flux:heading>Totaal Klanten</flux:heading>
            <flux:subheading class="text-2xl font-bold text-green-500">{{ $totalCustomers }}</flux:subheading>
        </div>

        <div class="border-2 rounded-lg p-4 my-6">
            <flux:heading>Actieve Klanten</flux:heading>
            <flux:subheading class="text-2xl font-bold text-purple-500">{{ $activeCustomers }}</flux:subheading>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="border-2 rounded-lg p-4">
            <h1 class="font-bold text-lg text-center p-2">Orders per Maand (6 maanden)</h1>
            <div style="position: relative; height: 300px;">
                <canvas id="ordersPerMonthChart"></canvas>
            </div>
        </div>
        <div class="border-2 rounded-lg p-4">
            <h1 class="font-bold text-lg text-center p-2">Klanten per Maand (6 maanden)</h1>
            <div style="position: relative; height: 300px;">
                <canvas id="customersPerMonthChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6 mb-6 mt-6">
        <div class="border-2 rounded-xl p-4">
            <flux:heading size="xl" class="mb-2">Offertes:</flux:heading>
            <flux:subheading size="xl" class="font-bold text-white mb-1">{{ $totalQuotes }}</flux:subheading>
            <flux:text icon="arrow-trending-down" color="red" class="text-sm font-bold">
                {{ $pendingQuotes }} openstaande offertes
            </flux:text>
        </div>

        <div class="border-2 rounded-xl p-4">
            <flux:heading size="xl" class="mb-2">Orders naar Status:</flux:heading>
            <div class="space-y-2">
                @forelse($ordersByStatus as $status)
                    <div class="flex justify-between">
                        <span class="font-semibold capitalize">{{ ucfirst($status->status) }}:</span>
                        <span class="font-bold text-white">{{ $status->count }}</span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Geen ordergegevens beschikbaar</p>
                @endforelse
            </div>
        </div>

        <div class="border-2 rounded-xl p-4">
            <flux:heading size="xl" class="mb-2">Top Klanten:</flux:heading>
            <div class="space-y-2 text-sm">
                @foreach($topCustomers->take(5) as $customer)
                    <div class="flex justify-between">
                        <span>{{ $customer->name }}</span>
                        <span class="font-bold text-white">{{ $customer->orders_count }} orders</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        console.log('Script loaded');
        
        function initCharts() {
            console.log('initCharts called');
            
            // Check if Chart is available
            if (typeof Chart === 'undefined') {
                console.error('Chart.js not loaded');
                setTimeout(initCharts, 500);
                return;
            }

            console.log('Chart.js is available');

            // Orders per month chart
            const ordersChartElement = document.getElementById('ordersPerMonthChart');
            if (ordersChartElement) {
                const ordersCtx = ordersChartElement.getContext('2d');
                const ordersData = {!! json_encode($ordersPerMonth->pluck('count')) !!};
                const ordersLabels = {!! json_encode($ordersPerMonth->pluck('month')) !!};
                
                console.log('Orders Data:', ordersData);
                console.log('Orders Labels:', ordersLabels);
                
                new Chart(ordersCtx, {
                    type: 'line',
                    data: {
                        labels: ordersLabels,
                        datasets: [{
                            label: 'Orders',
                            data: ordersData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3,
                            fill: true,
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#ffffff'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#ffffff'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#ffffff'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            }
                        }
                    }
                });
                console.log('Orders chart created');
            } else {
                console.error('Orders chart element not found');
            }

            // Customers per month chart
            const customersChartElement = document.getElementById('customersPerMonthChart');
            if (customersChartElement) {
                const customersCtx = customersChartElement.getContext('2d');
                const customersData = {!! json_encode($customersPerMonth->pluck('count')) !!};
                const customersLabels = {!! json_encode($customersPerMonth->pluck('month')) !!};
                
                console.log('Customers Data:', customersData);
                console.log('Customers Labels:', customersLabels);
                
                new Chart(customersCtx, {
                    type: 'bar',
                    data: {
                        labels: customersLabels,
                        datasets: [{
                            label: 'Nieuwe Klanten',
                            data: customersData,
                            backgroundColor: '#10b981',
                            borderColor: '#059669',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#ffffff'
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    color: '#ffffff'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#ffffff'
                                },
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.1)'
                                }
                            }
                        }
                    }
                });
                console.log('Customers chart created');
            } else {
                console.error('Customers chart element not found');
            }
        }

        // Initialize charts when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCharts);
        } else {
            initCharts();
        }
    </script>
</x-layouts.dashboard>
