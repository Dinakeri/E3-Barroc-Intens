<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['product', 'part', 'orderedBy'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('purchasing.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        $parts = Part::orderBy('name')->get();

        return view('purchasing.purchases.create', compact('products', 'parts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_type' => 'required|in:product,part',
            'product_id' => 'nullable|integer|exists:products,id',
            'part_id' => 'nullable|integer|exists:parts,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            $itemType = $validated['item_type'];
            $quantity = (int) $validated['quantity'];
            $unitCost = 0.0;

            $productId = null;
            $partId = null;

            if ($itemType === 'product') {
                $productId = (int) $request->input('product_id');
                $product = Product::findOrFail($productId);

                $unitCost = (float) $product->cost_price;

                if ($product->stock < $quantity) {
                    return redirect()->back()->withErrors([
                        'quantity' => 'Onvoldoende voorraad voor deze bestelling.'
                    ])->withInput();
                }

                $product->stock -= $quantity;
                if ($product->stock === 0) {
                    $product->status = 'out_of_stock';
                }
                $product->save();
            } else {
                $partId = (int) $request->input('part_id');
                $part = Part::findOrFail($partId);

                $unitCost = (float) $part->cost_price;

                if ($part->stock < $quantity) {
                    return redirect()->back()->withErrors([
                        'quantity' => 'Onvoldoende voorraad voor deze bestelling.'
                    ])->withInput();
                }

                $part->stock -= $quantity;
                if ($part->stock === 0) {
                    $part->status = 'out_of_stock';
                }
                $part->save();
            }

            $totalCost = $unitCost * $quantity;

            Purchase::create([
                'product_id' => $productId,
                'part_id' => $partId,
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'total_cost' => $totalCost,
                'ordered_by' => Auth::id(),
                'notes' => $validated['notes'] ?? null,
            ]);

            return redirect()->route('purchases.index')->with('success', 'Inkoop succesvol geregistreerd');
        });
    }
}
