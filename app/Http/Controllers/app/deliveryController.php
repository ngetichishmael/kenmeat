<?php

namespace App\Http\Controllers\app;

use Auth;
use Session;
use App\Models\User;
use App\Models\Orders;
use App\Models\Delivery;
use App\Models\customers;
use App\Models\Order_items;
use Illuminate\Http\Request;
use App\Models\order_payments;
use App\Http\Controllers\Controller;

class deliveryController extends Controller
{
   //index
   public function index(){
      return view('app.delivery.index');
   }

   public function details($code){
      $order = Delivery::where('business_code', Auth::user()->business_code)->where('order_code',$code)->first();
      $allocate = Delivery::select('allocated')->where('business_code', Auth::user()->business_code)->where('order_code',$code)->first();
      $user = User::select('name')->where('user_code',$allocate->allocated)->first();
      $items = Order_items::where('order_code',$order->order_code)->get();
      $Customer_id = Orders::select('customerID')->where('order_code', $code)->first();
      $id = $Customer_id->customerID;
      $test = customers::where('id',$id)->first();
      $payment = order_payments::where('order_id',$order->order_code)->first();
      // dd($user);
      return view('app.delivery.details', compact('order','items', 'test', 'payment', 'user'));
   }

   //allocation
   public function allocation(Request $request){
      return 'working';
   }
}
