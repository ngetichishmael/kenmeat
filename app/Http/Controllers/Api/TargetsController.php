<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TargetResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LeadsTargets;
use App\Models\OrdersTarget;
use App\Models\SalesTarget;
use App\Models\VisitsTarget;
use Carbon\Carbon;



class TargetsController extends Controller
{

   public function getSalespersonTarget(Request $request)
   {
       $user_code = $request->user()->user_code;
       $currentMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
   
       $target = User::with([
           'TargetSale' => function ($query) use ($currentMonth) {
               $query->where('Deadline', 'LIKE', substr($currentMonth, 0, 7) . '%');
           },
           'TargetLead' => function ($query) use ($currentMonth) {
               $query->where('Deadline', 'LIKE', substr($currentMonth, 0, 7) . '%');
           },
           'TargetsOrder' => function ($query) use ($currentMonth) {
               $query->where('Deadline', 'LIKE', substr($currentMonth, 0, 7) . '%');
           },
           'TargetsVisit' => function ($query) use ($currentMonth) {
               $query->where('Deadline', 'LIKE', substr($currentMonth, 0, 7) . '%');
           },
       ])
       ->where('user_code', $user_code)
       ->first();
   
       return response()->json([
           "success" => true,
           "message" => "Target Sets",
           "Targets" => new TargetResource($target),
       ]);
   }
    // public function getSalespersonTarget(Request $request)
    // {
    //    $user_code = $request->user()->user_code;
       
    //    // Calculate the current month's deadline
    //    $currentMonthDeadline = Carbon::now()->endOfMonth()->format('Y-m-d');
 
    //    $target = User::with([
    //       'TargetSale' => function ($query) use ($currentMonthDeadline) {
    //          $query->where('Deadline', $currentMonthDeadline);
    //       },
    //       'TargetLead' => function ($query) use ($currentMonthDeadline) {
    //          $query->where('Deadline', $currentMonthDeadline);
    //       },
    //       'TargetOrder' => function ($query) use ($currentMonthDeadline) {
    //          $query->where('Deadline', $currentMonthDeadline);
    //       },
    //       'TargetVisit' => function ($query) use ($currentMonthDeadline) {
    //          $query->where('Deadline', $currentMonthDeadline);
    //       }
    //    ])->where('user_code', $user_code)->first();
 
    //    return response()->json([
    //       "success" => true,
    //       "message" => "Target Set for the current month",
    //       "Targets" => new TargetResource($target),
    //    ]);
    // }

   public $targets = [
      'sales' => [
          'target' => 'SalesTarget',
          'achieved' => 'AchievedSalesTarget',
          'label' => 'Sales',
          'color' => '#fc0103',
      ],
      'leads' => [
          'target' => 'LeadsTarget',
          'achieved' => 'AchievedLeadsTarget',
          'label' => 'Leads',
          'color' => '#fc0103',
      ],
      'visit' => [
          'target' => 'VisitsTarget',
          'achieved' => 'AchievedVisitsTarget',
          'label' => 'Visits',
          'color' => '#fc0103',
      ],
      'order' => [
          'target' => 'OrdersTarget',
          'achieved' => 'AchievedOrdersTarget',
          'label' => 'Orders',
          'color' => '#fc0103',
      ],
  ];
  public function getTarget($type)
  {
      // Determine the model based on the selected type
      switch ($type) {
          case 'sales':
              $model = SalesTarget::class;
              break;
          case 'leads':
              $model = LeadsTargets::class;
              break;
          case 'visit':
              $model = VisitsTarget::class;
              break;
          case 'order':
              $model = OrdersTarget::class;
              break;
          default:
              // If the type is not recognized, return an empty response or an error message.
              return response()->json(['error' => 'Invalid target type'], 404);
      }
      $targetData = $this->targets[$type];

      $targetColumn = $targetData['target'];
      $achievedColumn = $targetData['achieved'];
      $achievedLabel = $targetData['label'];
      $color = $targetData['color'];

      $data = $model::selectRaw('MONTH(created_at) as month, SUM(' . $targetColumn . ') as total_target, SUM(' . $achievedColumn . ') as total_achieved')
          ->groupBy('month')
          ->get();
      $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      $targets = array_fill(0, 12, 0);
      $achieved = array_fill(0, 12, 0);

      foreach ($data as $entry) {
          // Subtract 1 because the month starts from 1 and array index starts from 0
          $monthIndex = (int) $entry->month - 1;
          $targets[$monthIndex] = $entry->total_target;
          $achieved[$monthIndex] = $entry->total_achieved;
      }

      // Return the data as JSON
      return response()->json([
          'labels' => $labels,
          'targets' => $targets,
          'achieved' => $achieved,
          'label' => $achievedLabel,
          'color' => $color,
      ]);
  }
}
