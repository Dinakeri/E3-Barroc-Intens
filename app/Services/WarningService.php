<?php

namespace App\Services;

use App\Models\Warning;

class WarningService
{
    /**
     * Create a low stock warning
     */
    public static function createLowStockWarning($productId, $productName, $currentStock, $minStock)
    {
        return Warning::updateOrCreate(
            [
                'type' => 'low_stock',
                'related_id' => $productId,
                'related_type' => 'product',
            ],
            [
                'title' => 'Lage voorraad',
                'message' => "Product '{$productName}' heeft een lage voorraad. Huidige voorraad: {$currentStock}, Minimum: {$minStock}",
                'severity' => $currentStock <= 0 ? 'critical' : 'warning',
                'is_resolved' => false,
                'resolved_at' => null,
            ]
        );
    }

    /**
     * Resolve low stock warning when stock is replenished
     */
    public static function resolveLowStockWarning($productId)
    {
        $warning = Warning::where('type', 'low_stock')
            ->where('related_id', $productId)
            ->where('related_type', 'product')
            ->where('is_resolved', false)
            ->first();

        if ($warning) {
            $warning->resolve();
        }
    }

    /**
     * Create an overdue order warning
     */
    public static function createOverdueOrderWarning($orderId, $orderNumber, $daysOverdue)
    {
        return Warning::updateOrCreate(
            [
                'type' => 'overdue_order',
                'related_id' => $orderId,
                'related_type' => 'order',
            ],
            [
                'title' => 'Achterstallige bestelling',
                'message' => "Bestelling #{$orderNumber} is {$daysOverdue} dagen te laat",
                'severity' => $daysOverdue > 7 ? 'critical' : 'warning',
                'is_resolved' => false,
                'resolved_at' => null,
            ]
        );
    }

    /**
     * Get all unresolved warnings count
     */
    public static function getUnresolvedCount()
    {
        return Warning::unresolved()->count();
    }

    /**
     * Get warnings by severity
     */
    public static function getBySeverity($severity)
    {
        return Warning::unresolved()->where('severity', $severity)->get();
    }
}
