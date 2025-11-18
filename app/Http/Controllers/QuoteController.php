<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        // 1. Create quote entry
        $quote = Quote::create([
            'customer_id' => $customer_id,
            'price' => 150.00,
            'status' => 'pending',
        ]);

        $customer = Customer::findOrFail($customer_id);

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
}
