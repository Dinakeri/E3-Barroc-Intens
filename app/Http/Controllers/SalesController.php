<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Quote;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function dashboard(): View
    {
        // Get total orders
        $totalOrders = Order::count();
        
        // Get total customers
        $totalCustomers = Customer::count();
        
        // Get total quotes
        $totalQuotes = Quote::count();
        
        // Get pending quotes (assuming quotes have a status field)
        $pendingQuotes = Quote::where('status', 'pending')->count();
        
        // Get active customers (customers with orders)
        $activeCustomers = Customer::whereHas('orders')->distinct()->count();
        
        // Get orders by status for chart - with error handling
        try {
            $ordersByStatus = Order::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get();
        } catch (\Exception $e) {
            // If status column doesn't exist, create empty array
            $ordersByStatus = collect([]);
        }
        
        // Get top customers by order count
        $topCustomers = Customer::withCount('orders')
            ->orderByDesc('orders_count')
            ->limit(10)
            ->get();
        
        // Get orders per month for the last 6 months
        $driver = \DB::getDriverName();
        if ($driver === 'sqlite') {
            $ordersPerMonth = Order::selectRaw('strftime("%Y-%m", created_at) as month, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $ordersPerMonth = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }
        
        // Get customers added per month for the last 6 months
        if ($driver === 'sqlite') {
            $customersPerMonth = Customer::selectRaw('strftime("%Y-%m", created_at) as month, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else {
            $customersPerMonth = Customer::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        return view('dashboards.sales', [
            'totalOrders' => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'totalQuotes' => $totalQuotes,
            'pendingQuotes' => $pendingQuotes,
            'activeCustomers' => $activeCustomers,
            'ordersByStatus' => $ordersByStatus,
            'topCustomers' => $topCustomers,
            'ordersPerMonth' => $ordersPerMonth,
            'customersPerMonth' => $customersPerMonth,
        ]);
    }
}
