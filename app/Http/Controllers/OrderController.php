<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderItems.product', 'customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        return view('orders.create', compact('customers', 'products'));
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'customer_id' => $data['customer_id'],
            'order_date' => $data['order_date'],
            'status' => $data['status'],
            'total_amount' => $data['total_amount'],
        ]);

        foreach ($data['items'] as $item) {
            $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('orders.show', $order);
    }

    public function edit(Order $order)
    {
        $products = Product::all();
        $customers = Customer::all();
        $existingItems = $order->orderItems->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
        });
        return view('orders.edit', compact('order', 'products', 'customers', 'existingItems'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'total_amount' => 'required|numeric|min:0',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $order->update([
            'customer_id' => $data['customer_id'],
            'order_date' => $data['order_date'],
            'status' => $data['status'],
            'total_amount' => $data['total_amount'],
        ]);

        $existingItemIds = [];

        foreach ($data['items'] as $item) {
            $orderItem = $order->orderItems()->updateOrCreate(
                ['product_id' => $item['product_id']],
                [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]
            );
            $existingItemIds[] = $orderItem->id;
        }

        // Delete removed items
        $order->orderItems()->whereNotIn('id', $existingItemIds)->delete();

        return redirect()->route('orders.show', $order);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index');
    }
}
