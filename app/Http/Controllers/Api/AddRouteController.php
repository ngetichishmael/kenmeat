<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper as HelpersHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer\customers;
use App\Models\Routes;
use App\Models\Route_customer;
use App\Models\Route_sales;
use Illuminate\Support\Facades\Auth;

class AddRouteController extends Controller
{
   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {


      $code =  HelpersHelper::generateRandomString(20);
      $route = new Routes;
      $route->business_code = Auth::user()->business_code;
      $route->route_code = $code;
      $route->name = $request->name;
      $route->status = $request->status;
      $route->start_date = $request->start_date;
      $route->end_date = $request->end_date;
      $route->created_by = Auth::user()->user_code;
      $route->save();

      return response()->json([
         "success" => true,
         "status" => 200,
         "message" => "Successfully",
      ]);
   }
}
