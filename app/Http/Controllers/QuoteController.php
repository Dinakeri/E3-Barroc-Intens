<?php

namespace App\Http\Controllers;

use App\Mail\QuoteSentMail;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;



class QuoteController extends Controller
{

    public function index()
    {
        $quotes = Quote::with('customer')->orderBy('created_at', 'desc')->paginate(20);

        return view('quotes.index', compact('quotes'));
    }

    public function updateStatus(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,sent,approved,rejected',
        ]);

        $quote->update($validated);

        return redirect()->back()->with('success', 'Quote status updated successfully. Status: ' . $quote->status);
    }

    public function generatePdf($customer_id)
    {
        $customer = Customer::with('orders')->findOrFail($customer_id);

        if ($customer->bkr_status !== 'cleared') {
            abort(403, 'Klant heeft geen geldige BKR-check');
        }

        if ($customer->status !== 'active') {
            abort(403, 'Klant is niet actief');
        }

        $order = Order::where('customer_id', $customer->id)->whereHas('orderItems')->orderBy('created_at')->firstOrFail();
        // dd($order->orderItems);

        $total_amount = $order->total_amount;


        // 1. Create quote entry
        $quote = Quote::create([
            'customer_id' => $customer_id,
            'status' => 'draft',
            'total_amount' => $total_amount,
        ]);


        // 2. Generate PDF with Barryvdh/Dompdf
        $pdf = FacadePdf::loadView('quotes.template', [
            'customer' => $customer,
            'quote' => $quote,
            'order' => $order,
        ]);

        // 3. Create PDF filename
        $pdfName = 'quotes/quote_' . $quote->id . '.pdf';

        // 4. Save PDF to storage
        Storage::disk('public')->put($pdfName, $pdf->output());

        // 5. Save PDF URL to database
        $quote->url = $pdfName;
        $quote->save();

        // 6. Return PDF to browser
        return $pdf->stream("offerte_{$quote->id}.pdf");
    }


    public function create()
    {
        $customers = Customer::with('orders', 'quotes')->orderBy('name')->get();
        return view('quotes.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_id' => 'required|exists:orders,id',
            'valid_until' => 'required|date|after:today',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);
        $order = Order::findOrFail($validated['order_id']);

        // dd( $customer, $order);
        $quote = Quote::create([
            'customer_id' => $customer->id,
            'order_id' => $order->id,
            'total_amount' => $order->total_amount,
            'valid_until' => $validated['valid_until'],
            'status' => 'draft',
        ]);

        $pdf = FacadePdf::loadView('quotes.template', [
            'customer' => $customer,
            'quote' => $quote,
            'order' => $order,
        ]);

        $pdfName = 'quotes/quote_' . $quote->id . '.pdf';

        Storage::disk('public')->put($pdfName, $pdf->output());

        $quote->url = $pdfName;
        $quote->save();

        return redirect()->route('quotes.index')->with('success', 'Offerte succesvol aangemaakt.');
    }


    public function show(Quote $quote)
    {
        $quote->load('customer');

        return view('quotes.show', compact('quote'));
    }


    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,sent,approved,rejected',
            'valid_until' => 'required|date|after:today',
        ]);

        $quote->update($validated);

        $pdf = FacadePdf::loadView('quotes.template', [
            'customer' => $quote->customer,
            'quote' => $quote,
            'order' => $quote->order,
        ]);

        $pdfName = 'quotes/quote_' . $quote->id . '.pdf';

        Storage::disk('public')->put($pdfName, $pdf->output());
        $quote->url = $pdfName;
        $quote->save();

        return redirect()->route('quotes.index')->with('success', 'Offerte succesvol bijgewerkt.');
    }


    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()->route('quotes.index')->with('success', 'Offerte succesvol verwijderd.');
    }

    public function send(Quote $quote)
    {
        // dd($quote);
        Mail::to($quote->customer->email)
            ->send(new QuoteSentMail($quote));

        $quote->update([
            'status' => 'sent',
        ]);

        return back()->with('success', 'Quote sent to customer.');
    }


    public function approve(Quote $quote)
    {
        abort_if($quote->status !== 'sent', 403);

        $quote->update(['status' => 'approved']);

        return view('quotes.result', [
            'title' => 'Offerte goedgekeurd',
            'message' => 'Bedankt! Wij nemen spoedig contact met u op.',
        ]);
    }


    public function reject(Quote $quote)
    {
        abort_if($quote->status !== 'sent', 403);

        $quote->update(['status' => 'rejected']);

        return view('quotes.result', [
            'title' => 'Offerte afgewezen',
            'message' => 'De offerte is afgewezen. Neem contact op bij vragen.',
        ]);
    }
}
