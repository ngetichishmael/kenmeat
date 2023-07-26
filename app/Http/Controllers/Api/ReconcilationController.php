<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Returnable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReconcilationController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $paymentMethods = ['Mpesa', 'Cash', 'Cheque'];

        $result = [];
        foreach ($paymentMethods as $method) {
            $totalAmount = DB::table('order_payments')
                ->where('payment_method', 'PaymentMethods.' . $method)
                ->where('isReconcile', 'false')
                ->where('user_id', $user_id)
                ->sum('amount');
            $result[$method] = $totalAmount;
        }
        Returnable::where('user_id', $user_id)
            ->where('status', 'Not Returned')
            ->update(['status' => 'Returned']);

        $returnables = Returnable::join('product_information', 'returnables.product_information_id', '=', 'product_information.id')
            ->join('product_price', 'product_price.productID', '=', 'returnables.product_information_id')
            ->where('returnables.user_id', '=', $user_id)
            ->where('returnables.status', 'Not Returned')
            ->select(
                'product_information.product_name as product_name',
                'product_information.sku_code as sku_code',
                'product_price.buying_price as buying_price',
                'product_price.selling_price as selling_price',
                'returnables.quantity as quantity'
            )
            ->get();

        return response()->json([
            "success" => true,
            "message" => "Total Amount Expected",
            "data" => $result,
            "returnable" => $returnables,
        ]);
    }

}
