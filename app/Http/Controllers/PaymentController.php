<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::paginate(20);
        return view('finance.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('finance.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        return view('finance.payments.edit', compact('payment'));
    }

    public function create()
    {
        $invoices = Invoice::all();
        return view('finance.payments.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'method' => 'nullable|in:credit_car,bank_transfer,cash',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'status' => 'required|string|max:50',
            'method' => 'required|string|max:255',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.show', $payment)->with('success', 'Payment updated successfully.');
    }
}
