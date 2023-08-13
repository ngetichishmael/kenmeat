<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\customer\checkin;
use App\Models\Orders;
use App\Models\customers;
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
      $vansalesCount = Orders::where('order_type', 'Van sales');
                
      if (empty($this->start) && empty($this->end)) {
          $currentMonth = now()->startOfMonth();
          $vansalesCount->whereBetween('updated_at', [$currentMonth, now()]);
      } else {
          if (!empty($this->start)) {
              $vansalesCount->where('updated_at', '>=', $this->start);
          }
          if (!empty($this->end)) {
              $vansalesCount->where('updated_at', '<=', $this->end);
          }
      }
  
      $Vansalescount = $vansalesCount->count();
      

      $salesTotal = Orders::with('user', 'customer')
        
         ->orderByDesc('updated_at') // Order by updated_at in descending order (most recent first)
         ->paginate($this->perVansale);



      $preorderCount = Orders::where('order_type', 'Pre Order');
                
      if (empty($this->start) && empty($this->end)) {
          $currentMonth = now()->startOfMonth();
          $preorderCount->whereBetween('created_at', [$currentMonth, now()]);
      } else {
          if (!empty($this->start)) {
              $preorderCount->where('created_at', '>=', $this->start);
          }
          if (!empty($this->end)) {
              $preorderCount->where('created_at', '<=', $this->end);
          }
      }
  
      $preordersCount = $preorderCount->count();

      $preorderTotal = Orders::with('user', 'customer')
         ->where('order_type', 'Pre Order')
         ->where(function (Builder $query) {
            $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
         })
         ->where('order_status', 'DELIVERED')
         ->paginate($this->perPreorder);

      // $orderfullment = Orders::where('order_status', 'DELIVERED')
      //    ->where(function (Builder $query) {
      //       $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
      //    })
      //    ->count();

      $orderfullment = Orders::whereIn('order_status', ['DELIVERED', 'Partial Delivery'])
      ->where('order_type', 'Pre Order')
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

      // $activeUser = checkin::where(function (Builder $query) {
      //    $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
      // })
      //    ->distinct('user_code')
      //    ->count();

      $activeUser = User::where('status', 'Active')->count();

      // $activeUserTotal = checkin::with('user', 'customer')
      //    ->distinct('user_code')
      //    ->groupBy('user_code')
      //    ->where(function (Builder $query) {
      //       $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
      //    })
      //    ->paginate($this->perActiveUsers);
      $activeUserTotal = User::orderBy('created_at', 'desc') // Order by the recently added users first
      ->take(10) // Limit the query to get only the latest 10 users
      ->get();


      $strikeCount = Checkin::query();

      if (!empty($this->start) || !empty($this->end)) {
          $strikeCount->where(function (Builder $query) {
              $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
          });
      }
  
      $strikeCount = $strikeCount->count();
         
         $visitsTotal = checkin::with('user', 'customer')
         ->orderBy('created_at', 'desc') // Order by the latest visits first
         ->take(10) // Limit the query to get only the latest 10 visits
         ->get();
     
     // Calculate the duration for each visit and update the $visitsTotal collection
     foreach ($visitsTotal as $visit) {
         if ($visit->stop_time === null) {
             // Visit is active, calculate the duration from 'created_at' to now
             $duration = Carbon::parse($visit->created_at)->diffForHumans(null, true);
         } else {
             // Visit is complete, calculate the duration from 'created_at' to 'stop_time'
             $duration = Carbon::parse($visit->created_at)->diffForHumans($visit->stop_time, true);
         }
     
         // Update the 'duration' attribute of the visit with the calculated duration
         $visit->duration = $duration;
     }



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


      // $customersCount = Orders::distinct('customerID')
      //    ->where(function (Builder $query) {
      //       $this->whereBetweenDate($query, 'updated_at', $this->start, $this->end);
      //    })
      //    ->count();
      $customersCount = customers::query();

         if (empty($this->start) && empty($this->end)) {
             $currentMonth = Carbon::now()->startOfMonth();
             $customersCount->whereBetween('created_at', [$currentMonth, Carbon::now()]);
         } else {
             if (!empty($this->start)) {
                 $customersCount->where('created_at', '>=', $this->start);
             }
             if (!empty($this->end)) {
                 $customersCount->where('created_at', '<=', $this->end);
             }
         }
     
         $customersCount = $customersCount->count();



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
         'vansales' => $Vansalescount,
         'preorder' => $preordersCount,
         'orderfullment' => $orderfullment,
         'activeUser' => $activeUser,
         'activeAll' => $activeAll,
         'strike' => $strikeCount,
         'customersCount' => $customersCount,
         'salesTotal' => $salesTotal,
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
