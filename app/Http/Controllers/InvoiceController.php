<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Order;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function create()
    {
        $customers = Customer::with('contracts', 'orders')->orderBy('name')->get();
        $contracts = Invoice::with('customer')->orderByDesc('created_at')->paginate(15);
        return view('invoices.create', compact('customers', 'contracts'));
    }

    /**
     * Show a listing of stored invoices.
     */
    public function index()
    {
        $invoices = Invoice::with('customer')->orderByDesc('created_at')->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Display a single invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('customer', 'order', 'contract', 'payments');
        return view('invoices.show', compact('invoice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'contract_id' => 'required|exists:contracts,id',
            'order_id' => 'required|exists:orders,id',
            'valid_until' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,cancelled',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);
        $contract = Contract::findOrFail($validated['contract_id']);
        $order = Order::findOrFail($validated['order_id']);

        $invoice = Invoice::create([
            'customer_id' => $contract->customer_id,
            'contract_id' => $contract->id,
            'order_id' => $validated['order_id'],
            'total_amount' => $validated['total_amount'],
            'valid_until' => $validated['valid_until'],
            'status' => $validated['status'],
        ]);

        $pdf = FacadePdf::loadView('invoices.template', [
            'invoice' => $invoice,
            'customer' => $customer,
            'order' => $order,
            'contract' => $contract,
        ]);

        $path = "invoices/invoice-{$invoice->id}.pdf";
        Storage::disk('public')->put($path, $pdf->output());

        $invoice->update(['pdf_path' => $path]);

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Factuur succesvol aangemaakt.');
    }

    public function send(Invoice $invoice)
    {
        $invoice->load('customer', 'order', 'contract');
        Mail::to($invoice->customer->email)->send(new InvoiceMail($invoice));

        $invoice->update(['status' => 'sent']);

        return redirect()->route('invoices.show', $invoice->id)->with('success', 'Factuur succesvol verzonden.');
    }
}
