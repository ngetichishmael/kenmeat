<?php

namespace App\Http\Livewire\Productapproval;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StockRequisition;
use App\Models\RequisitionProduct;
use App\Models\products\product_information;

class Approval extends Component
{
   use WithPagination;
   protected $paginationTheme = 'bootstrap';
   public $perPage = 10;
   public function render()
   {
      $requisitions = StockRequisition::with('user')->withCount('RequisitionProducts', 'ApprovedRequisitionProducts') ->orderBy('id', 'DESC')->paginate($this->perPage);

      return view('livewire.productapproval.approval', compact('requisitions'));
   }


   public function approvestock($requisition_id){
      $requisition_products = RequisitionProduct::where('requisition_id',$requisition_id)->get();
      foreach ($requisition_products as $requisition_product){
         $approveproduct = product_information::whereId($requisition_product)->first();
         $approveproduct->is_approved = "Yes";
         $approveproduct->save();
      }
      session()->flash('success', 'Product successfully Approved !');
   }
}
