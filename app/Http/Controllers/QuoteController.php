<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;



class QuoteController extends Controller
{
    // public function userInvoice(Request $request, string $invoiceId)
    // {

    //     return $request->user()->downloadInvoice($invoiceId, [], 'my-invoice');
    // }

    public function generatePdf($customer_id)
    {
        $quote = Quote::create([
            'customer_id' => $customer_id,
            'price' => 150.00, // or calculate dynamically
            'status' => 'pending',
        ]);

        $customer = Customer::findOrFail($customer_id);
        $quote = $customer->quote;


        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);


        $html = view('quotes.index', compact('customer', 'quote'))->render();
        $dompdf->loadHtml($html);


        // $dompdf->setPaper('A4', 'portrait');


        // $dompdf->render();


        // return response($dompdf->output(), 200)
        //     ->header('Content-Type', 'application/pdf')
        //     ->header('Content-Disposition', 'inline; filename="sample.pdf"');

        $pdf = FacadePdf::loadView('quotes.index', [
            'customer' => $customer,
            'quote' => $quote,
        ]);

        return $pdf->stream("offerte_{$quote->id}.pdf");
    }
}
