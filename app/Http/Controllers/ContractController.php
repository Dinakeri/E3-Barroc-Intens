<?php

namespace App\Http\Controllers;

use App\Mail\ContractMail;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Quote;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Mail;

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
            'status' => 'pending',
        ]);

        $pdf = FacadePdf::loadView('contracts.template', [
            'contract' => $contract,
            'quote' => $quote,
            'customer' => $contract->customer,
            'order' => $quote->order,
        ]);

        $path = "contracts/contract-{$contract->id}.pdf";
        Storage::disk('public')->put($path, $pdf->output());

        $contract->update(['pdf_path' => $path]);

        $invoice = Invoice::create([
            'customer_id' => $contract->customer_id,
            'contract_id' => $contract->id,
            'order_id' => $quote->order_id,
            'total_amount' => $contract->total_amount,
            'valid_until' => now()->addDays(30),
            'status' => 'draft',
        ]);

        $inv_pdf = FacadePdf::loadView('invoices.template', [
            'invoice' => $invoice,
            'customer' => $contract->customer,
            'items' => $quote->order->orderItems,
        ]);

        $inv_path = "invoices/invoice-{$invoice->id}.pdf";
        Storage::disk('public')->put($inv_path, $inv_pdf->output());

        $invoice->update(['pdf_path' => $inv_path]);

        return redirect()
            ->route('contracts.show', [$contract, $invoice])
            ->with('success', 'Contract gegenereerd. Wacht op goedkeuring.');
    }

    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,expired,terminated',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $contract->update($validated);

        $pdf = FacadePdf::loadView('contracts.template', [
            'contract' => $contract,
            'quote' => $contract->quote,
            'customer' => $contract->customer,
            'order' => $contract->quote->order,
        ]);

        $path = "contracts/contract-{$contract->id}.pdf";
        Storage::disk('public')->put($path, $pdf->output());

        $contract->update(['pdf_path' => $path]);

        return redirect()
            ->route('contracts.show', $contract)
            ->with('success', 'Contractstatus bijgewerkt.');
    }


    public function show(Contract $contract)
    {
        $contract->load('customer', 'quote.order', 'quote.order.orderItems', 'invoices');
        return view('contracts.show', compact('contract'));
    }

    public function send(Contract $contract)
    {
        $invoice = Invoice::where('contract_id', $contract->id)->where('order_id', $contract->quote->order_id)->latest()->first();
        Mail::to($contract->customer->email)->send(new ContractMail($contract, $invoice));

        $invoice->update(['status' => 'sent']);

        return redirect()
            ->route('contracts.show', $contract)
            ->with('success', 'Contract verzonden naar klant.');
    }

    public function approve(Contract $contract)
    {
        // abort_if($contract->status !== 'pending', 403, 'Contract is niet in afwachting van goedkeuring.');


        return view('contracts.result', [
            'title' => 'Contract Goedgekeurd',
            'message' => 'Het contract is goedgekeurd en de factuur is automatisch aangemaakt.',
        ]);
    }

    public function reject(Contract $contract)
    {
        abort_if($contract->status !== 'pending', 403, 'Contract is niet in afwachting van goedkeuring.');

        $contract->update(['status' => 'rejected']);

        return view('contracts.result', [
            'title' => 'Contract Afgewezen',
            'message' => 'Het contract is afgewezen. Neem contact op met onze klantenservice voor meer informatie.',
        ]);
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contract succesvol verwijderd.');
    }
}
