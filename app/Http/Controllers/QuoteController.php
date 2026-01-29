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

        $total_amount = $order->orderItems->sum(fn($item) => $item->qty * $item->price);


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



    public function preview(Quote $quote)
    {
        $quote->load('customer');

        return view('quotes.preview', compact('quote'));
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
