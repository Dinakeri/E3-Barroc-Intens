<?php

namespace App\Observers;

use App\Models\Payment;
use App\Services\InventoryService;

class PaymentObserver
{
    public function created(Payment $payment): void
    {
        if ($payment->status === 'completed') {
            app(InventoryService::class)->decrementForInvoice($payment->invoice);
        }
    }

    public function updated(Payment $payment): void
    {
        if ($payment->isDirty('status') && $payment->status === 'completed') {
            app(InventoryService::class)->decrementForInvoice($payment->invoice);
        }
    }
}
