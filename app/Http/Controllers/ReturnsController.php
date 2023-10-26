<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturnsController extends Controller
{
    public function index()
    {
       return view('livewire.returns.layout');
    }

    public function show($customerId)
    {
        $customer = customers::find($customerId);
        $returnedProducts = $customer->returnedProducts; // Assuming you have a relationship set up

        // Return a view to display the returned products
        return view('returned-products.index', compact('returnedProducts', 'customer'));
    }

}
