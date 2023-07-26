<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Activity;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer\Checkin;
use App\Models\Orders as Order;
use App\Models\Order_items;
use App\Models\ProductInformation;
use App\Models\StockLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckingSaleOrderController extends Controller
{

    public function amount(Request $request, $checkinCode)
    {
        $checkin = Checkin::where('code', $checkinCode)->first();
        $requestData = $request->json()->all();
        $total = 0;

        foreach ($requestData as $value) {
            $product = ProductInformation::with('ProductPrice')
                ->where('id', $value["productID"])
                ->where('business_code', $checkin->business_code)
                ->first();
            $total_amount = $value["qty"] * $value["price"];
            $total += $total_amount;
        }

        return $total;
    }

    public function processOrder(Request $request, $checkinCode, $random, $orderType)
    {
        $user_code = $request->user()->user_code;
        $user_id = $request->user()->id;
        $requestData = $request->json()->all();
        $total = 0;

        foreach ($requestData[0]['cartItem'] as $value) {
            $product = ProductInformation::where('id', $value["productID"])->first();
            $price_total = $value["qty"] * $value["price"];
            $total += $price_total;

            $this->updateOrCreateCartItem($random, $value, $user_code, $product);

            DB::table('inventory_allocated_items')
                ->where('product_code', $value["productID"])
                ->decrement('allocated_qty', $value["qty"], [
                    'updated_at' => now(),
                ]);

            $this->updateOrCreateOrder($random, $value, $checkinCode, $total, $user_code, $orderType);

            $this->createOrderItem($random, $value, $product);

            $this->logActivity($product->product_name, $orderType, 'Conduct a ' . $orderType, $user_id, $user_code, $request->ip() ?? "127.0.0.1", "App");
        }

        foreach ($requestData[0]['stock_levels'] as $stockLevel) {
            StockLevel::create([
                'product_information_id' => $stockLevel['product_id'],
                'stock_level' => $stockLevel['stock_level'],
                'lpo_number' => $requestData[0]['lpo_number'],
                'user_id' => $user_id,
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Product added to order",
            "order_code" => $random,
        ]);
    }

    private function updateOrCreateCartItem($random, $value, $user_code, $product)
    {
        Cart::updateOrCreate(
            [
                'checkin_code' => Str::random(20),
                "order_code" => $random,
            ],
            [
                'productID' => $value["productID"],
                "product_name" => $product->product_name,
                "qty" => $value["qty"],
                "price" => $value["price"],
                "amount" => $value["qty"] * $value["price"],
                "total_amount" => $value["qty"] * $value["price"],
                "userID" => $user_code,
            ]
        );
    }

    private function updateOrCreateOrder($random, $value, $checkinCode, $total, $user_code, $orderType)
    {
        Order::updateOrCreate(
            [
                'order_code' => $random,
            ],
            [
                'user_code' => $user_code,
                'customerID' => $checkinCode,
                'price_total' => $total,
                'balance' => $total,
                'order_status' => 'Pending Delivery',
                'payment_status' => 'Pending Payment',
                'qty' => $value["qty"],
                'discount' => $value["discount"] ?? "0",
                'checkin_code' => $checkinCode,
                'order_type' => $orderType,
                'delivery_date' => now(),
                'business_code' => $user_code,
                'updated_at' => now(),
            ]
        );
    }

    private function createOrderItem($random, $value, $product)
    {
        Order_items::create([
            'order_code' => $random,
            'productID' => $value["productID"],
            'product_name' => $product->product_name,
            'quantity' => $value["qty"],
            'sub_total' => $value["qty"] * $value["price"],
            'total_amount' => $value["qty"] * $value["price"],
            'selling_price' => $value["price"],
            'discount' => 0,
            'taxrate' => 0,
            'taxvalue' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function logActivity($productName, $activityType, $description, $userId, $userCode, $ipAddress, $appName)
    {
        (new Activity)($activityType . " for product " . $productName, $activityType, $description, $userId, $userCode, $ipAddress, $appName);
    }

    public function VanSales(Request $request, $checkinCode, $random)
    {
        return $this->processOrder($request, $checkinCode, $random, 'Van sales');
    }

    public function NewSales(Request $request, $checkinCode, $random)
    {
        return $this->processOrder($request, $checkinCode, $random, 'Pre Order');
    }

}
