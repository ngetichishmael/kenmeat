<?php

namespace App\Http\Controllers\app;

use App\Charts\BrandSales;
use App\Charts\CatergoryChart;
use App\Charts\SalesTargetChart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\order_payments as OrderPayment;
use App\Models\Orders;
use App\Models\SalesTarget;
use App\Models\User;
use Carbon\Carbon;

class sokoflowController extends Controller
{
   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      // $this->middleware('auth');
   }


   /**
    * dashboard controller instance.
    */
   public function dashboard()
   {

      $today = Carbon::today();
      $week = Carbon::now()->subWeeks(1);
      $month = Carbon::now()->subMonth(1);
      $year = Carbon::now()->subYears(1);

      $daily = DB::table('order_payments')
         ->whereDate('created_at', $today)
         ->sum('amount');
      $weekly = DB::table('order_payments')
         ->whereBetween('created_at', [$week, $today])
         ->sum('amount');
      $monthly = DB::table('order_payments')
         ->whereBetween('created_at', [$week, $today])
         ->sum('amount');
      $sumAll = DB::table('order_payments')
         ->sum('amount');
      $vansales = Orders::where('order_type', 'Van sales')
         ->where('order_status', 'DELIVERED')
         ->sum('price_total');
      $preorder = Orders::where('order_type', 'Pre Order')
         ->where('order_status', 'DELIVERED')
         ->sum('price_total');
      $orderfullment = Orders::where('order_status', 'DELIVERED')
         ->count();
      // $activeUser = DB::table('customer_checkin')
      //    ->distinct('user_code')
      //    ->whereDate('created_at', Carbon::today())
      //    ->count();
      $activeUser = DB::table('users')
      ->count();
      
      $activeAll = User::where('account_type', 'Sales')->count();
      $sales = DB::table('order_payments')
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile', 'user_id')
         ->where('user_id', auth()->id())->sum('balance');

      $cash = OrderPayment::where('payment_method', 'PaymentMethods.Cash')->sum('amount');
      $mpesa = OrderPayment::where('payment_method', 'PaymentMethods.Mpesa')->sum('amount');
      $cheque = OrderPayment::where('payment_method', 'PaymentMethods.Cheque')->sum('amount');

      $strike = DB::table('customer_checkin')->whereDate('created_at', Carbon::today())->count();
      $customersCount = Orders::distinct('customerID')->whereDate('created_at', Carbon::today())->count();

      return view('app.dashboard.dashboard', [
         'Cash' => $cash,
         'Mpesa' => $mpesa,
         'Cheque' => $cheque,
         'sales' => $sales,
         'total' => $cash + $cheque + $mpesa,
         'vansales' => $vansales,
         'preorder' => $preorder,
         'orderfullment' => $orderfullment,
         'activeUser' => $activeUser,
         'activeAll' => $activeAll,
         'daily' => $daily,
         'weekly' => $weekly,
         'monthly' => $monthly,
         'sumAll' => $sumAll,
         'strike' => $strike,
         'customersCount' => $customersCount
      ]);

      // return view('app.dashboard.dashboard',compact('Cash', 'Mpesa','Cheque','reconciled','total'));
   }

   //user summary
   public function user_summary()
   {
      return view('app.dashboard.user-summary');
   }
}
