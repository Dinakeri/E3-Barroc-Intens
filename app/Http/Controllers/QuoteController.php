<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
        $customer = Customer::findOrFail($customer_id);

        $customer = Customer::findOrFail($customer_id);

        // $data = [
        //     'customer' => $customer,
        //     // 'quotes' => $customer->quotes,
        // ];

        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);


        $html = view('quotes.index', compact('customer'))->render();
        $dompdf->loadHtml($html);


        $dompdf->setPaper('A4', 'portrait');


        $dompdf->render();


        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="sample.pdf"');
    }
}
