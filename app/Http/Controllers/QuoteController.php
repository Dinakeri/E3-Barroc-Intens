<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use PDF;



class QuoteController extends Controller
{
    // public function userInvoice(Request $request, string $invoiceId)
    // {

    //     return $request->user()->downloadInvoice($invoiceId, [], 'my-invoice');
    // }

    public function generatePdf($customer_id)
    {
        $customer = Customer::with('orders')->findOrFail($customer_id);

        if ($customer->bkr_status !== 'cleared') {
            abort(403, 'Klant heeft geen geldige BKR-check');
        }

        if ($customer->status !== 'active') {
            abort(403, 'Klant is niet actief');
        }

        $order = Order::where('customer_id', $customer->id)->latest()->firstOrFail();

        $total_amount = $order->orderItems->sum(fn($item) => $item->qty * $item->price);


        // 1. Create quote entry
        $quote = Quote::create([
            'customer_id' => $customer_id,
            'status' => 'draft',
            'total_amount' => $total_amount,
        ]);


        // 2. Generate PDF with Barryvdh/Dompdf
        $pdf = FacadePdf::loadView('quotes.index', [
            'customer' => $customer,
            'quote' => $quote,
        ]);

        // 3. Create PDF filename
        $pdfName = 'quotes/quote_' . $quote->id . '.pdf';

        // 4. Save PDF to storage
        Storage::disk('public')->put($pdfName, $pdf->output());

        // 5. Save PDF URL to database
        $quote->url = Storage::url($pdfName);
        $quote->save(); // ← THIS is the missing part

        // 6. Return PDF to browser
        return $pdf->stream("offerte_{$quote->id}.pdf");
    }

    public function accept(Quote $quote)
    {
        if ($quote->status !== 'sent') abort(403);

        $quote->update(['status' => 'accepted']);

        $contract = Contract::create([
            'customer_id' => $quote->customer_id,
            'quote_id' => $quote->id,
            'start_date' => now(),
            'status' => 'active',
        ]);

        foreach ($quote->items as $item) {
            $contract->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        return view('quotes.result', [
            'message' => 'Offerte succesvol geaccepteerd!'
        ]);
    }

    public function reject(Quote $quote)
    {
        $quote->update(['status' => 'rejected']);

        return view('quotes.result', [
            'message' => 'Offerte is afgewezen.'
        ]);
    }
}
