<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\inventory\allocations;
use App\Models\Returnable;
use Illuminate\Http\Request;

class ReturnableController extends Controller
{
    public function returnProducts(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|numeric',
            'products' => 'required|array',
            'products.*.product_id' => 'required|numeric',
            'products.*.quantity' => 'required|numeric|min:1',
        ]);

        $customer_id = $validatedData['customer_id'];
        $products = $validatedData['products'];

        // Create returnable entries
        foreach ($products as $product) {
            Returnable::create([
                'product_id' => $product['product_id'],
                'product_information_id' => $product['product_id'],
                'customer_id' => $customer_id,
                'customers_id' => $customer_id,
                'quantity' => $product['quantity'],
                'expiry_date' => $product['expiry_date'],
                'status' => 'Not Returned',
                'user_id' => $request->user()->id,
            ]);
        }

        return response()->json(['message' => 'Returnable products added successfully']);
    }

    public function reconcilePayment(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|numeric',
            'products' => 'required|array',
            'products.*.product_id' => 'required|numeric',
            'products.*.quantity' => 'required|numeric|min:1',
        ]);

        $customer_id = $validatedData['customer_id'];
        $products = $validatedData['products'];

        // Update the status of returnables to "Returned"
        foreach ($products as $product) {
            Returnable::where('customer_id', $customer_id)
                ->where('product_id', $product['product_id'])
                ->where('status', 'Not Returned')
                ->take($product['quantity'])
                ->update(['status' => 'Returned']);
        }

        return response()->json(['message' => 'Returnables reconciled successfully']);
    }

    public function reconcileProductWithPayment($customer_id)
    {
        // Get all returnables for the given customer_id
        $returnables = Returnable::where('customer_id', $customer_id)->get();

        // Update the status of all returnables to "Returned"
        foreach ($returnables as $returnable) {
            $returnable->update(['status' => 'Returned']);
        }

        return response()->json(['message' => 'Returnables reconciled successfully']);
    }
   public function unreconciled(Request $request){
      $usercode = $request->user()->user_code;
      $unreconciled=allocations::where('sales_person', $usercode)->where('status', 'Accepted')->get();
      return response()->json([
         "success" => true,
         "message" => "All unreconciled products",
         "data" =>$unreconciled
      ]);
   }
   public function returnables(Request $request){
      $id = $request->user()->id;
      $returnables=Returnable::where('user_id','=', $id)->where('status', 'Not Returned')->get();
      return response()->json([
         "success" => true,
         "message" => "All unreconciled products",
         "data" =>$returnables
      ]);
   }
}
