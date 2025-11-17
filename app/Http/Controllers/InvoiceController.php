<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        return view('invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'items' => 'nullable|array',
            'items_json' => 'nullable|string',
        ]);

        // Parse items: either from structured items or JSON textarea
        $items = [];
        if (! empty($validated['items'])) {
            $items = $validated['items'];
        } elseif (! empty($validated['items_json'])) {
            $items = json_decode($validated['items_json'], true) ?: [];
        }

        if (empty($items)) {
            return back()->withErrors(['items' => 'Geen items opgegeven']);
        }

        $total = collect($items)->sum(fn($i) => $i['qty'] * $i['price']);

        $invoice = Invoice::create([
            'customer_id' => $validated['customer_id'],
            'total_amount' => $total,
            'invoice_date' => $validated['invoice_date'],
            'due_date' => $validated['due_date'],
        ]);

        $customer = Customer::find($validated['customer_id']);

        $html = view('invoices.template', ['invoice' => $invoice, 'customer' => $customer, 'items' => $items])->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="invoice-' . $invoice->id . '.pdf"');
    }

    public function downloadPdf(Invoice $invoice)
    {
        $customer = $invoice->customer;

        // Since invoice items are not stored in DB in this schema, create a placeholder
        $items = [
            ['description' => 'Service A', 'qty' => 1, 'price' => $invoice->total_amount],
        ];

        $html = view('invoices.template', compact('invoice', 'customer', 'items'))->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="invoice-' . $invoice->id . '.pdf"');
    }

    public function testPdf()
    {
        $customer = Customer::first();
        if (! $customer) {
            abort(404, 'No customer found — run customers seeder first');
        }

        $data = [
            'customer' => $customer,
            'invoice' => (object) [
                'id' => 'TEST-1',
                'invoice_date' => now()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
                'total_amount' => 150.00,
            ],
            'items' => [
                ['description'=>'Product X','qty'=>2,'price'=>25],
                ['description'=>'Product Y','qty'=>1,'price'=>100],
            ],
        ];

        $html = view('invoices.template', $data)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        return response($output, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="test-invoice.pdf"');
    }
}

