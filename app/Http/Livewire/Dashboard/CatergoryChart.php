<?php

namespace App\Http\Livewire\Dashboard;

use App\Charts\CatergoryChart as ChartsCatergoryChart;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CatergoryChart extends Component
{
    public function render()
    {

      $createdTimeLine = DB::select('SELECT
      DATE_FORMAT(created_at,\'%M:%Y\') AS creation,
                     SUM(total_amount) AS total
                  FROM
                     `order_items`
                  GROUP BY
                     `creation`
                  ORDER BY
                     `total`
                  ASC');
      $arrayTLabel = [];
      $arrayTData = [];
      foreach ($createdTimeLine as $br) {
         array_push($arrayTLabel, $br->creation);
         array_push($arrayTData, $br->total);
      }
      $createdTimeLine = new ChartsCatergoryChart();
      $createdTimeLine->labels($arrayTLabel);
      $createdTimeLine->dataset('Monthly Performance', 'line', $arrayTData)->options([
         "responsive" => true,
         'color' => "#94DB9D",
         'backgroundColor' => '#07ed6f',
         "borderWidth" => 2,
         "borderRadius" => 5,
         "borderSkipped" => true,
         "beginAtZero"=>true,
      ]);

        return view('livewire.dashboard.catergory-chart',[

         'catergories' => $createdTimeLine,
        ]);
    }
}
