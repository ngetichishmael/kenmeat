<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\customer\checkin;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use App\Models\order_payments as OrderPayment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class Dashboard extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $start;
   public $end;
   public  $daily;
   public  $weekly;
   public  $monthly;
   public  $sumAll;
   public $perVansale = 10;
   public $perPreorder = 10;
   public $perBuyingCustomer = 10;
   public $perVisits = 10;
   public $perOrderFulfilment = 10;
   public $perActiveUsers = 10;

   public function whereBetweenDate(Builder $query, string $column = null, string $start = null, string $end = null): Builder
   {
      if (is_null($start) && is_null($end)) {
         return $query;
      }

      if (!is_null($start) && Carbon::parse($start)->isSameDay(Carbon::parse($end))) {
         return $query->where($column, '=', $start);
      }
      $end = $end == null ? Carbon::now()->endOfMonth()->format('Y-m-d') : $end;
      return $query->whereBetween($column, [$start, $end]);
   }
   public function render()
   {



      $vansales = Orders::where('order_type', 'Van sales')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->where('order_status', 'DELIVERED')
         ->sum('price_total');

      $vansalesTotal = Orders::with('user', 'customer')
         ->where('order_type', 'Van sales')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->where('order_status', 'DELIVERED')
         ->paginate($this->perVansale);

      $preorder = Orders::where('order_type', 'Pre Order')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->where('order_status', 'DELIVERED')
         ->sum('price_total');

      $preorderTotal = Orders::with('user', 'customer')
         ->where('order_type', 'Pre Order')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->where('order_status', 'DELIVERED')
         ->paginate($this->perPreorder);

      $orderfullment = Orders::where('order_status', 'DELIVERED')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->count();

      $orderfullmentTotal = Orders::with('user', 'customer')
         ->where('order_status', 'DELIVERED')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->paginate($this->perOrderFulfilment);

      $activeUser = checkin::where(function (Builder $query) {
         $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
      })
         ->distinct('user_code')
         ->count();

      $activeUserTotal = checkin::with('user', 'customer')
         ->distinct('user_code')
         ->groupBy('user_code')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->paginate($this->perActiveUsers);

      $strike = checkin::where(function (Builder $query) {
         $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
      })
         ->count();

      $visitsTotal = checkin::with('user', 'customer')
         ->groupBy('customer_id')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->paginate($this->perVisits);




      $activeAll = User::where('account_type', '<>', 'Admin')
         ->count();
      $sales = OrderPayment::where(function (Builder $query) {
         $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
      })
         ->select('id', 'amount', 'balance', 'payment_method', 'isReconcile', 'user_id')
         ->sum('balance');

      $cash = OrderPayment::where('payment_method', 'PaymentMethods.Cash')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->sum('amount');
      $mpesa = OrderPayment::where('payment_method', 'PaymentMethods.Mpesa')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->sum('amount');
      $cheque = OrderPayment::where('payment_method', 'PaymentMethods.Cheque')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->sum('amount');
      $bank = OrderPayment::where('payment_method', 'PaymentMethods.BankTransfer')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->sum('amount');


      $customersCount = Orders::distinct('customerID')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->count();
      $customersCountTotal = Orders::with('user', 'customer')
         ->groupBy('customerID')
         ->distinct('customerID')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->paginate($this->perBuyingCustomer);
      return view('livewire.dashboard.dashboard', [
         'Cash' => $cash,
         'Mpesa' => $mpesa,
         'Cheque' => $cheque,
         'sales' => $sales,
         'total' => $bank,
         'vansales' => $vansales,
         'preorder' => $preorder,
         'orderfullment' => $orderfullment,
         'activeUser' => $activeUser,
         'activeAll' => $activeAll,
         'strike' => $strike,
         'customersCount' => $customersCount,
         'vansalesTotal' => $vansalesTotal,
         'preorderTotal' => $preorderTotal,
         'activeUserTotal' => $activeUserTotal,
         'orderfullmentTotal' => $orderfullmentTotal,
         'visitsTotal' => $visitsTotal,
         'customersCountTotal' => $customersCountTotal,
      ]);
   }
   public function mount()
   {
      $today = Carbon::today();
      $week = Carbon::now()->subWeeks(1);

      $this->daily = DB::table('order_payments')
         ->sum('amount');
      $this->weekly = DB::table('order_payments')
         ->sum('amount');
      $this->monthly = DB::table('order_payments')
         ->whereBetween('created_at', [$week, $today])
         ->sum('amount');
      $this->sumAll = DB::table('order_payments')
         ->sum('amount');
   }
   public function updatedStart()
   {
      $this->mount();
      $this->render();
   }
   public function updatedEnd()
   {
      $this->mount();
      $this->render();
   }
}
