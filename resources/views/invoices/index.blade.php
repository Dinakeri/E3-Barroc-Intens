<x-layouts.dashboard title="Opgeslagen facturen">
    <h1 class="text-2xl font-bold mb-4">Opgeslagen facturen</h1>

    @section('title', 'Financien Dashboard')
    @section('sidebar')
        @include('partials.FinanceSidebar')
    @endsection

    @if($invoices->count())
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="p-2">#</th>
                        <th class="p-2">Klant</th>
                        <th class="p-2">Datum</th>
                        <th class="p-2">Totaal</th>
                        <th class="p-2">PDF</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $inv)
                        <tr class="border-b">
                            <td class="p-2">{{ $inv->id }}</td>
                            <td class="p-2">{{ optional($inv->customer)->name }}</td>
                            <td class="p-2">{{ $inv->invoice_date->toDateString() }}</td>
                            <td class="p-2">€ {{ number_format($inv->total_amount, 2, ',', '.') }}</td>
                            <td class="p-2">
                                @if($inv->pdf_path)
                                    <a href="{{ route('invoices.pdf', $inv) }}" class="text-blue-500">Open / Download</a>
                                @else
                                    <span class="text-gray-500">Nog niet gegenereerd</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $invoices->links() }}</div>
    @else
        <p>Er zijn nog geen facturen opgeslagen.</p>
    @endif
</x-layouts.dashboard>
