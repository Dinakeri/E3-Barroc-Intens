<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class BkrController extends Controller
{
    public function index()
    {
        return Customer::all();
    }

    public function performBkrCheck(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status' => 'required|in:registered,cleared',
        ]);

        $customer = Customer::findOrFail($request->input('customer_id'));

        // Simuleer een BKR-check (in een echte applicatie zou je hier een API-aanroep doen)
        $bkrStatus = $request->input('status');

        $customer->bkr_status = $bkrStatus;
        if ($bkrStatus === 'registered') {
            $customer->status = 'inactive';
        }
        else {
            $customer->status = 'active';
        }
        $customer->save();

        return redirect()->back()->with('success', 'BKR-check uitgevoerd voor ' . $customer->name . '. Status: ' . $bkrStatus);
    }
}
