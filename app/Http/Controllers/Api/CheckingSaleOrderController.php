<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer\checkin;
use App\Models\products\product_information;
use App\Models\Cart;
use App\Models\customers;
use App\Models\Order_items;
use App\Models\Orders as Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CheckingSaleOrderController extends Controller
{

   public function amount(Request $request, $checkinCode)
   {
      $checkin = checkin::where('code', $checkinCode)->first();
      $request = $request->collect();
      $total = 0;
      foreach ($request as $value) {
         $product = product_information::with('ProductPrice')
            ->where('id', $value["productID"])
            ->where('business_code', $checkin->business_code)
            ->first();
         $total_amount = $value["qty"] *  $value["price"];
         $total += $total_amount;
      }
      return $total;
   }

   //Start Vansales
   public function VanSales(Request $request, $checkinCode, $random)
   {
      $checkin = checkin::where('code', $checkinCode)->first();
      $user_code = $request->user()->user_code;
      $total = 0;
      $request = $request->collect();
      foreach ($request as $value) {
         $price_total = $value["qty"] * $value["price"];
         $total += $price_total;
         $product = product_information::with('ProductPrice')->where('id', $value["productID"])->first();
         Cart::updateOrCreate(
            [
               'checkin_code' => $checkinCode,
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
         DB::table('inventory_allocated_items')
            ->where('product_code', $value["productID"])
            ->decrement(
               'allocated_qty',
               $value["qty"],
               [
                  'updated_at' => now()
               ]
            );
         Order::updateOrCreate(
            [

               'order_code' => $random,
            ],
            [
               'user_code' => $user_code,
               'customerID' => $checkin->customer_id,
               'price_total' => $total,
               'balance' => $total,
               'order_status' => 'Pending Delivery',
               'payment_status' => 'Pending Payment',
               'qty' => $value["qty"],
               'discount' => $items["discount"] ?? "0",
               'checkin_code' => $checkinCode,
               'order_type' => 'Van sales',
               'delivery_date' => now(),
               'business_code' => $checkin->business_code,
               'updated_at' => now(),
            ]
         );
         Order_items::create([
            'order_code' => $random,
            'productID' => $value["productID"],
            'product_name' => $product->product_name,
            'quantity' => $value["qty"],
            'sub_total' => $value["qty"] * $value["price"],
            'total_amount' => $value["qty"] * $value["price"],
            'selling_price' => $value["price"],
            'discount' => $items["discount"]  ?? "0",
            'taxrate' => 0,
            'taxvalue' => 0,
            'created_at' => now(),
            'updated_at' => now(),
         ]);
         (new Activity)(
            "Van Sales for product " . $product->product_name,
            "Van Sale",
            'Conduct a Van Sales',
            $request->user()->id,
            $request->user()->user_code,
            $request->ip() ?? "127.0.0.1",
            "App"
         );
      }
      return response()->json([
         "success" => true,
         "message" => "Product added to order",
         "order_code" => $random,
         "data"    => $checkin
      ]);
   }

   //End of Vansales
   //Start Vansales
   public function VanSales12(Request $request, $checkinCode, $random)
   {
      $amountRequest = $request;
      $checkin = checkin::where('code', $checkinCode)->first();
      $user_code = $request->user()->user_code;
      $requests = $request->collect();
      foreach ($requests as $items) {
         info("Van sales Cart Items");
         info($items);
         foreach ($items["cartItem"] as $value) {
            info("Van sales Cart Items");
            info($value);
            $product = product_information::with('ProductPrice')->where('id', (int)$value["productID"])->first();
            Cart::updateOrCreate(
               [
                  'checkin_code' => $checkinCode,
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
            DB::table('inventory_allocated_items')
               ->where('product_code', $value["productID"])
               ->decrement(
                  'allocated_qty',
                  $value["qty"],
                  [
                     'updated_at' => now()
                  ]
               );
            Order::updateOrCreate(
               [

                  'order_code' => $random,
               ],
               [
                  'user_code' => $user_code,
                  'customerID' => $checkin->customer_id,
                  'price_total' => $value["qty"] * $value["price"],
                  'balance' => $value["qty"] * $value["price"],
                  'order_status' => 'Pending Delivery',
                  'payment_status' => 'Pending Payment',
                  'qty' => $value["qty"],
                  'discount' => $items["discount"] ?? "0",
                  'checkin_code' => $checkinCode,
                  'order_type' => 'Van sales',
                  'delivery_date' => now(),
                  'business_code' => $checkin->business_code,
                  'updated_at' => now(),
               ]
            );
            Order_items::create([
               'order_code' => $random,
               'productID' => $value["productID"],
               'product_name' => $product->product_name,
               'quantity' => $value["qty"],
               'sub_total' => $value["qty"] * $value["price"],
               'total_amount' => $value["qty"] * $value["price"],
               'selling_price' => $value["price"],
               'discount' => $items["discount"]  ?? "0",
               'taxrate' => 0,
               'taxvalue' => 0,
               'created_at' => now(),
               'updated_at' => now(),
            ]);
         }
      }
      return response()->json([
         "success" => true,
         "message" => "Product added to order",
         "order_code" => $random,
         "data"    => $checkin
      ]);
   }

   //End of Vansales


   // Beginning of NewSales
   public function NewSales(Request $request, $checkinCode, $random)
   {
      // $checkin = customers::whereId($checkinCode)->first();

      $user_code = $request->user()->user_code;
      $request = $request->collect();
      $total = 0;
      foreach ($request as $value) {
         $price_total = $value["qty"] * $value["price"];
         $total += $price_total;
         $product = product_information::whereId($value["productID"])->first();
         Cart::updateOrCreate(
            [
               'checkin_code' => Str::random(20),
               "order_code" => $random,
            ],
            [
               'productID' => $value["productID"],
               "product_name" => $product->product_name,
               "qty" => $value["qty"],
               "price" =>  $value["price"],
               "amount" => $value["qty"] *  $value["price"],
               "total_amount" => $value["qty"] *  $value["price"],
               "userID" => $user_code,
            ]
         );
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
               'discount' => $items["discount"] ?? "0",
               'checkin_code' => $checkinCode,
               'order_type' => 'Pre Order',
               'delivery_date' => now(),
               'business_code' => $user_code,
               'updated_at' => now(),
            ]
         );
         Order_items::create([
            'order_code' => $random,
            'productID' => $value["productID"],
            'product_name' => $product->product_name,
            'quantity' => $value["qty"],
            'sub_total' => $value["qty"] *  $value["price"],
            'total_amount' => $value["qty"] *  $value["price"],
            'selling_price' =>  $value["price"],
            'discount' => 0,
            'taxrate' => 0,
            'taxvalue' => 0,
            'created_at' => now(),
            'updated_at' => now(),
         ]);

         DB::table('orders_targets')
            ->where('user_code', $user_code)
            ->increment('AchievedOrdersTarget', $value["qty"]);

         (new Activity)(
            "New Sales for product " . $product->product_name,
            "New Sale",
            'Conduct a New Sales',
            $request->user()->id,
            $request->user()->user_code,
            $request->ip() ?? "127.0.0.1",
            "App"
         );
      }
      return response()->json([
         "success" => true,
         "message" => "Product added to order",
         "order_code" => $random,
         "data"    => null
      ]);
   }
}