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
      $Sokoflow = suppliers::where('name', 'LIKE', '%Sokoflow%')->first();
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

      $preOrderCounts = Orders::where('order_type', 'Pre Order')
         ->whereIn('supplierID', [$Sokoflow->id, '', null])
         ->where('order_status', 'DELIVERED')
         ->selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
         ->groupBy('month')
         ->pluck('count', 'month')
         ->toArray();

      $deliveryCounts = Orders::where('order_status', 'LIKE', '%deliver%')
         ->whereYear('created_at', '=', date('Y'))
         ->selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
         ->groupBy('month')
         ->pluck('count', 'month')
         ->toArray();

      $graphdata = [];
      for ($month = 1; $month <= 12; $month++) {
         $graphdata[] = [
            'month' => $months[$month],
            'preOrderCount' => $preOrderCounts[$month] ?? 0,
            'deliveryCount' => $deliveryCounts[$month] ?? 0,
         ];
      }

      return $graphdata;
   }
}