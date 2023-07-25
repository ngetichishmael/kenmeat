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
   public function view(): View
   {
      return view('Exports.visits', [
         'visits' => checkin::all()
      ]);
   }
}
