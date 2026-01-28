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
            <flux:navlist.item href="{{ route('dashboards.calendar.worker') }}" class="mb-4" icon="calendar-days">Kalender</flux:navlist.item>
            <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>
            <flux:navlist.item href="{{ route('dashboard') }}" class="mb-4" icon="home">Dashboard</flux:navlist.item>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:navlist.item as="button" type="submit" class="mb-4 mt-auto w-full text-left" icon="arrow-left-end-on-rectangle">
                    Uitloggen
                </flux:navlist.item>
            </form>
        </flux:navlist>
    @endsection
    <flux:spacer class="my-4 border-t border-neutral-700"></flux:spacer>

    <main>
        <div class="text-white flex flex-col gap-6 items-start overscroll-x-none">
            <div class="w-full flex gap-8 items-start">
                <div class="flex flex-col gap-4 items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Installaties</h2>
                        <div>
                            <canvas class="w-[500px]" id="totalInstallationsLineChart"></canvas>
                        </div>
                    </div>
                    <div class="group relative flex w-64 h-12 items-center justify-center border border-zinc-500 bg-white/10 text-zinc-100 transition-all duration-300 ease-out hover:border-[#fdd716] hover:h-62 hover:bg-[#212121] hover:text-[#fdd716] overflow-hidden">                        <div class="absolute inset-x-0 top-0 flex flex-col gap-3 p-6 opacity-0 translate-y-2 transition-all duration-300 ease-out group-hover:opacity-100 group-hover:translate-y-0">
                            <a class="text-xl font-bold" href="">Bekijk alle installaties</a>
                            <p class="text-sm text-[#fdd716]/80">Ontdek de volledige lijst met installaties.</p>
                        </div>
                        <svg class="absolute bottom-4 left-1/2 -translate-x-1/2 w-8 h-8 text-inherit transition-transform duration-300 ease-out group-hover:translate-y-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-4 items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Onderhoud</h2>
                        <div>
                            <canvas class="w-[500px]" id="totalMaintenancesLineChart"></canvas>
                        </div>
                    </div>
                    <div class="group relative flex w-64 h-12 items-center justify-center border border-zinc-500 bg-white/10 text-zinc-100 transition-all duration-300 ease-out hover:border-[#fdd716] hover:h-62 hover:bg-[#212121] hover:text-[#fdd716] overflow-hidden">                        <div class="absolute inset-x-0 top-0 flex flex-col gap-3 p-6 opacity-0 translate-y-2 transition-all duration-300 ease-out group-hover:opacity-100 group-hover:translate-y-0">
                            <a class="text-xl font-bold" href="">Bekijk alle onderhoudsbeurten</a>
                            <p class="text-sm text-[#fdd716]/80">Zie planning en historische onderhoudslogs.</p>
                        </div>
                        <svg class="absolute bottom-4 left-1/2 -translate-x-1/2 w-8 h-8 text-inherit transition-transform duration-300 ease-out group-hover:translate-y-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col gap-4 items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-2">Storingen</h2>
                        <div>
                            <canvas class="w-[500px]" id="totalIncidentsLineChart"></canvas>
                        </div>
                    </div>
                    <div class="group relative flex w-64 h-12 items-center justify-center border border-zinc-500 bg-white/10 text-zinc-100 transition-all duration-300 ease-out hover:border-[#fdd716] hover:h-62 hover:bg-[#212121] hover:text-[#fdd716] overflow-hidden">
                        <div class="absolute inset-x-0 top-0 flex flex-col gap-3 p-6 opacity-0 translate-y-2 transition-all duration-300 ease-out group-hover:opacity-100 group-hover:translate-y-0">
                            <a class="text-xl font-bold" href="">Bekijk alle storingen</a>
                            <p class="text-sm text-[#fdd716]/80">Analyseer alle incidentmeldingen en trends.</p>
                        </div>
                        <svg class="absolute bottom-4 left-1/2 -translate-x-1/2 w-8 h-8 text-inherit transition-transform duration-300 ease-out group-hover:translate-y-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class="mt-12 rounded-xl border border-zinc-200 bg-[#202020] p-6 text-white shadow-sm">
                    <div class="flex flex-col gap-1 mb-6">
                        <h3 class="text-2xl font-semibold">Onderhoudsoverzicht</h3>
                        <p class="text-sm text-zinc-100">Recent ingeplande of afgeronde onderhoudstaken.</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-zinc-200 text-left text-sm font-semibold text-white">
                                    <th class="px-4 py-3">Taak</th>
                                    <th class="px-4 py-3">Bedrijf</th>
                                    <th class="px-4 py-3">Product</th>
                                    <th class="px-4 py-3">Datum</th>
                                    <th class="px-4 py-3">Toegewezen</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-right">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-100 text-sm">
                                @forelse ($recentMaintenances as $maintenance)
                                    @php
                                        $isPast = $maintenance->Date
                                            ? \Illuminate\Support\Carbon::parse($maintenance->Date)->isPast()
                                            : null;
                                        $statusLabel = $isPast === null ? 'Onbekend' : ($isPast ? 'Afgerond' : 'Gepland');
                                        $statusColor = $isPast === null ? 'zinc' : ($isPast ? 'green' : 'yellow');
                                        $statusIcon = $isPast === null ? 'question-mark-circle' : ($isPast ? 'check-circle' : 'calendar-days');
                                    @endphp
                                    <tr class="transition-colors hover:bg-zinc-50">
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-white-900">{{ $maintenance->Title ?? '—' }}</div>
                                            <p class="text-xs text-zinc-100 line-clamp-1">{{ $maintenance->Content }}</p>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-zinc-300">#{{ $maintenance->Company ?? '—' }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-zinc-300">{{ $maintenance->Product ?? '—' }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $maintenance->Date ? \Illuminate\Support\Carbon::parse($maintenance->Date)->format('d-m-Y') : '—' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $maintenance->AssignedTo ?? 'Niet toegewezen' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:badge color="{{ $statusColor }}" icon="{{ $statusIcon }}">
                                                {{ $statusLabel }}
                                            </flux:badge>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex justify-end gap-2">
                                                <flux:button size="sm" variant="ghost">
                                                    Bekijk taak
                                                </flux:button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-6 text-center text-zinc-100">
                                            Er zijn nog geen onderhoudstaken gevonden.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.dashboard>
