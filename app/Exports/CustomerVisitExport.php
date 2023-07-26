<?php

namespace App\Exports;

use App\Models\customer\checkin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerVisitExport implements FromView
{

     /**
     * @return \Illuminate\Support\FromView
     */

     protected $timeInterval;

     public function __construct($timeInterval = null)
     {
         $this->timeInterval = $timeInterval;
     }
 
 
     public function view(): View
     {
         $query = checkin::orderBy('created_at', 'DESC'); // Order by created_at in descending order (most recent first)
 
         if ($this->timeInterval === 'today') {
             $query->whereDate('created_at', today());
         } elseif ($this->timeInterval === 'yesterday') {
             $query->whereDate('created_at', today()->subDay());
         } elseif ($this->timeInterval === 'this_week') {
             $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
         } elseif ($this->timeInterval === 'this_month') {
             $query->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
         } elseif ($this->timeInterval === 'this_year') {
             $query->whereYear('created_at', now()->year);
         }
 
         $checkin = $query->get();
 
         return view('Exports.visits', [
             'visits' => $checkin,
         ]);
     }

}
