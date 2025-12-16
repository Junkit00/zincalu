<?php

namespace App\Http\Controllers;

use App\Models\Part;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Part::select('customer')
            ->distinct()
            ->orderBy('customer')
            ->pluck('customer');

        return view('customers.index', compact('customers'));
    }

    public function parts($customer)
    {
        $parts = Part::where('customer', $customer)
            ->orderBy('part_name')
            ->get();

        return view('customers.part', compact('customer', 'parts'));
    }
}
