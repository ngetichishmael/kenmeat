<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\inventory\allocations;
use App\Models\inventory\items;
use App\Models\ReconciledProducts as ReconciledProducts;
use App\Models\Returnable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReconciledProductsController extends Controller
{
    public function index(Request $request)
    {
        $usercode = $request->user()->user_code;
        $id = $request->user()->id;
        $request = $request->collect();
        foreach ($request as $data) {
            $reconciled_products = new ReconciledProducts();
            $reconciled_products->productID = $data['productID'];
            $reconciled_products->amount = $data['amount'];
            $reconciled_products->supplierID = $data['supplierID'];
            $reconciled_products->userCode = $usercode;
            $reconciled_products->save();

            Returnable::create([
                'product_id' => $data['productID'],
                'product_information_id' => $data['productID'],
                'customer_id' => $data['customer_id'] ?? 1,
                'customers_id' => $data['customer_id'] ?? 1,
                'quantity' => $data['amount'],
                'status' => 'Not Returned',
                'user_id' => $id,
            ]);

            DB::table('inventory_allocated_items')
                ->where('created_by', $usercode)
                ->decrement('allocated_qty', $data['amount'], [
                    'updated_at' => now(),
                ]);
            DB::table('inventory_allocated_items')
                ->where('allocated_qty', '<', 1)
                ->delete();

            DB::table('product_inventory')
                ->where('created_by', $usercode)
                ->increment('current_stock', $data['amount'], [
                    'updated_at' => now(),
                    'updated_by' => $id,
                ]);
            DB::table('order_payments')
                ->where('user_id', $id)
                ->update(['isReconcile' => 'true']);
        }

        return response()->json([
            "success" => true,
            "message" => "All products were successfully reconciled",
            "Result" => "Successful",
        ]);
    }

}
