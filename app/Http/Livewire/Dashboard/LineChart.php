<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Orders;
use App\Models\suppliers\suppliers;
use Livewire\Component;

class LineChart extends Component
{
   public function render()
   {
      return view('livewire.dashboard.line-chart', [

         'graphdata' => $this->getGraphData(),
      ]);
   }

   public function getGraphData()
   {
       $months = [
           1 => 'Jan',
           2 => 'Feb',
           3 => 'Mar',
           4 => 'Apr',
           5 => 'May',
           6 => 'Jun',
           7 => 'Jul',
           8 => 'Aug',
           9 => 'Sep',
           10 => 'Oct',
           11 => 'Nov',
           12 => 'Dec',
       ];
   
       $totalOrderSale = Orders::where('payment_status', 'PAID')
           ->selectRaw('MONTH(updated_at) as month, SUM(price_total) as total_sale')
           ->groupBy('month')
           ->pluck('total_sale', 'month')
           ->toArray();
   
       $graphdata = [];
       for ($month = 1; $month <= 12; $month++) {
           $graphdata[] = [
               'month' => $months[$month],
               'totalSale' => $totalOrderSale[$month] ?? 0,
           ];
       }
   
       return $graphdata;
   }
   
}