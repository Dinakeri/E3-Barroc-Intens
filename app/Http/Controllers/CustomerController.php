<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class CustomerController extends Controller
{
    use WithPagination;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at')->paginate(25);
        return view('customers.index', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'contact_person' => 'nullable|string',
            'place' => 'nullable|string',
            'house_number' => 'nullable|integer',
            'postcode' => 'nullable|string',
            'street' => 'nullable|string',
            'kvk_number' => 'nullable|integer',
            'status' => 'nullable|in:new,active,pending,inactive',
            'notes' => 'nullable|string',
        ]);
        // dd($validated);
        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // $customer = Customer::findOrFail($customer_id);
        return view('customers.show', compact('customer'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
