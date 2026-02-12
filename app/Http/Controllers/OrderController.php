<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $order = DB::transaction(function () use ($data) {
            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'order_date' => $data['order_date'],
                'status' => $data['status'],
                'total_amount' => $data['total_amount'],
            ]);

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    return redirect()->back()->withErrors([
                        'items' => 'Onvoldoende voorraad voor ' . $product->name . '.',
                    ])->withInput();
                }

                $product->stock -= $item['quantity'];
                if ($product->stock === 0) {
                    $product->status = 'out_of_stock';
                }
                $product->save();

                $order->orderItems()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            return $order;
        });

        if ($order instanceof \Illuminate\Http\RedirectResponse) {
            return $order;
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

        $result = DB::transaction(function () use ($data, $order) {
            $order->update([
                'customer_id' => $data['customer_id'],
                'order_date' => $data['order_date'],
                'status' => $data['status'],
                'total_amount' => $data['total_amount'],
            ]);

            $existingItems = $order->orderItems()->get()->keyBy('product_id');
            $incomingItems = collect($data['items'])->keyBy('product_id');

            $allProductIds = $existingItems->keys()->merge($incomingItems->keys())->unique();

            foreach ($allProductIds as $productId) {
                $oldQty = (int) optional($existingItems->get($productId))->quantity;
                $newQty = (int) optional($incomingItems->get($productId))['quantity'];
                $delta = $newQty - $oldQty;

                if ($delta !== 0) {
                    $product = Product::findOrFail($productId);

                    if ($delta > 0 && $product->stock < $delta) {
                        return redirect()->back()->withErrors([
                            'items' => 'Onvoldoende voorraad voor ' . $product->name . '.',
                        ])->withInput();
                    }

                    $product->stock -= $delta;
                    if ($product->stock === 0) {
                        $product->status = 'out_of_stock';
                    } elseif ($product->stock > 0 && $product->status === 'out_of_stock') {
                        $product->status = 'active';
                    }
                    $product->save();
                }
            }

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

            $order->orderItems()->whereNotIn('id', $existingItemIds)->delete();

            return $order;
        });

        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        return redirect()->route('orders.show', $order);
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index');
    }
}
