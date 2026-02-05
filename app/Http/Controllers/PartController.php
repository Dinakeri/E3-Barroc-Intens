<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::orderBy('name')->paginate(20);
        return view('purchasing.parts.index', compact('parts'));
    }

    public function create()
    {
        return view('purchasing.parts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:parts,sku',
            'cost_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'status' => 'required|in:active,phased_out,out_of_stock',
            'location' => 'nullable|string|max:255',
        ]);

        if ((int) $validated['stock'] === 0) {
            $validated['status'] = 'out_of_stock';
        }

        Part::create($validated);

        return redirect()->route('parts.index')->with('success', 'Onderdeel succesvol aangemaakt');
    }

    public function edit(Part $part)
    {
        return view('purchasing.parts.edit', compact('part'));
    }

    public function update(Request $request, Part $part)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:parts,sku,' . $part->id,
            'cost_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'status' => 'required|in:active,phased_out,out_of_stock',
            'location' => 'nullable|string|max:255',
        ]);

        if ((int) $validated['stock'] === 0) {
            $validated['status'] = 'out_of_stock';
        }

        $part->update($validated);

        return redirect()->route('parts.index')->with('success', 'Onderdeel succesvol bijgewerkt');
    }

    public function destroy(Part $part)
    {
        $part->delete();

        return redirect()->route('parts.index')->with('success', 'Onderdeel succesvol verwijderd');
    }
}
