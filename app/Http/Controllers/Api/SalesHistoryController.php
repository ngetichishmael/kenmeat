<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class SalesHistoryController extends Controller
{
    public function index(Request $request, $shopID)
    {
        $user_code = $request->user()->user_code;

        $query = Orders::where('user_code', $user_code)
            ->where('customerID', $shopID)
            ->select(
                'customerID',
                'user_code',
                'order_code',
                'price_total',
                'order_status',
                'payment_status',
                'checkin_code',
                'order_type',
                'created_at'
            )
            ->get();

        return response()->json([
            "success" => true,
            "message" => "Sales / Van Sales",
            "Data" => $query,
        ]);
    }

    public function vansales(Request $request, $shopID)
    {
        $user_code = $request->user()->user_code;
        $vansales = 'Van sales';

        $query = Orders::where('order_type', $vansales)
            ->where('user_code', $user_code)
            ->where('customerID', $shopID)
            ->get();

        return response()->json([
            "success" => true,
            "message" => "Van Sales Order",
            "Data" => $query,
        ]);
    }

    public function preorder($shopID)
    {
        $query = Orders::where("order_type", 'Pre order')
            ->where('customerID', $shopID)
            ->get();

        return response()->json([
            "success" => true,
            "message" => "New Sales Order",
            "Data" => $query,
        ]);
    }
}
