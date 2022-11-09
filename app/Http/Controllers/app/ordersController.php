<?php

namespace App\Http\Controllers\app;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\customers;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Order_items;
use App\Models\warehousing;
use App\Models\Delivery_items;
use App\Models\Delivery;
use App\Models\order_payments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ordersController extends Controller
{
   //orders
   public function index()
   {
      return view('app.orders.index');
   }

   //order details
   public function details($code)
   {
      $order = Orders::where('business_code', Auth::user()->business_code)->where('order_code', $code)->first();
      // dd($code);
      $items = Order_items::where('order_code', $order->order_code)->get();
      $sub = Order_items::select('sub_total')->where('order_code', $order->order_code)->get();
      $total = Order_items::select('total_amount')->where('order_code', $order->order_code)->get();
      $Customer_id = Orders::select('customerID')->where('order_code', $code)->first();
      $id = $Customer_id->customerID;
      $test = customers::where('id', $id)->first();
      // dd($test->id);
      $payment = order_payments::where('order_id', $order->order_code)->first();
      // dd($payment);
      return view('app.orders.details', compact('order', 'items', 'test', 'payment', 'sub', 'total'));
   }

   //allocation
   public function allocation($code)
   {
      $order = Orders::where('business_code', Auth::user()->business_code)->where('order_code', $code)->first();
      $items = Order_items::where('order_code', $order->order_code)->get();
      $users = User::where('business_code', Auth::user()->business_code)->orderby('id', 'desc')->get();
      $warehouses = warehousing::where('business_code', Auth::user()->business_code)->orderby('id', 'desc')->get();

      return view('app.orders.allocation', compact('order', 'items', 'users', 'warehouses'));
   }

   //create delivery
   public function delivery(Request $request)
   {
      $this->validate($request, [
         'user' => 'required',
         'warehouse' => 'required',
      ]);

      //check allocation
      $checkAllocation = count(collect($request->allocate));
      if ($checkAllocation > 0) {

         //create delivery
         $delivery = new Delivery;
         $delivery->business_code = Auth::user()->business_code;
         $delivery->delivery_code = Helper::generateRandomString(20);
         $delivery->order_code = $request->order_code;
         $delivery->allocated = $request->user;
         $delivery->delivery_note = $request->note;
         $delivery->delivery_status = 'Waiting acceptance';
         $delivery->customer = $request->customer;
         $delivery->created_by = Auth::user()->user_code;
         $delivery->save();


         //upload new category
         for ($i = 0; $i < count($request->allocate); $i++) {
            $items = new Delivery_items;
            $items->business_code = Auth::user()->business_code;
            $items->delivery_code = $delivery->delivery_code;
            $items->delivery_item_code = Helper::generateRandomString(20);
            // $items->item_code =  $request->item_code[$i];
            $items->allocated_quantity = $request->allocate[$i];
            $items->created_by = Auth::user()->user_code;
            $items->save();
         }

         Session::flash('success', 'Delivery created and orders allocated');

         return redirect()->route('delivery.index');
      } else {
         Session::flash('success', 'Please allocate items');

         return redirect()->back();
      }
   }
}
