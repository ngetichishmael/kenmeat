<?php

namespace App\Http\Controllers\app;

use App\Models\Delivery;
use App\Http\Controllers\Controller;

class deliveryController extends Controller
{

   public function index()
   {
      return view('app.delivery.index');
   }
   public function details($code)
   {
      $total = 0;
      $subtotal = 0;
      $deliveries = Delivery::with('User', 'DeliveryItems')
         ->where('order_code', $code)
         ->select('*')
         ->limit(1)
         ->get();
      return view('app.delivery.invoice', compact('deliveries', 'code', 'total', 'subtotal'));
   }
}
