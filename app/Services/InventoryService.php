<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function decrementForInvoice(Invoice $invoice): void
    {
        $order = $invoice->order;

        if (!$order) {
            return;
        }

        $order->load('orderItems.product');

        DB::transaction(function () use ($order) {
            foreach ($order->orderItems as $item) {
                if (in_array($item->status, ['completed', 'cancelled'], true)) {
                    continue;
                }

                $product = $item->product;
                if (!$product) {
                    continue;
                }

                $newStock = max(0, $product->stock - $item->quantity);
                $product->stock = $newStock;
                if ($newStock === 0) {
                    $product->status = 'out_of_stock';
                }
                $product->save();

                $item->status = 'completed';
                $item->save();
            }
        });
    }
}
