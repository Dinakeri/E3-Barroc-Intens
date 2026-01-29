<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quote;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('customer.quotes')->latest()->get();

        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $customers = Customer::with('quotes')->orderBy('name')->get();
        return view('contracts.create', compact('customers'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quote_id' => 'required|exists:quotes,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $quote = Quote::findOrFail($validated['quote_id']);

        $contract = Contract::create([
            'customer_id' => $validated['customer_id'],
            'quote_id' => $quote->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_amount' => $quote->total_amount,
            'status' => 'active',
        ]);

        $html = view('contracts.template', [
            'contract' => $contract,
            'quote' => $quote,
            'customer' => $contract->customer,
        ])->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4');
        $pdf->render();

        $path = "contracts/contract-{$contract->id}.pdf";
        Storage::disk('public')->put($path, $pdf->output());

        $contract->update(['pdf_path' => $path]);

        return redirect()
            ->route('contracts.show', $contract)
            ->with('success', 'Contract gegenereerd. Wacht op goedkeuring.');
    }

    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    public function approve(Contract $contract)
    {
        $contract->update(['status' => 'approved']);

        $invoice = Invoice::create([
            'customer_id' => $contract->customer_id,
            'contract_id' => $contract->id,
            'total_amount' => $contract->total_amount,
            'invoice_date' => now(),
            'due_date' => now()->addDays(14),
        ]);

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Contract goedgekeurd en factuur automatisch aangemaakt.');
    }
}
