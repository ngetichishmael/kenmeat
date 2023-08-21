<?php

namespace App\Http\Livewire\Customers;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AllocationsTracking extends Component
{
   use WithPagination;
   public $perPage = 10;
   public $search = '';
   public $customerid;
   public function mount($customerid)
   {
      $this->customerid = $customerid;
   }
   public function render()
   {
      $allocations = Delivery::where('customer', $this->customerid)->with('createdBy','DeliveryItems','Customer','User' )->search($this->search)
//         ->join('inventory_allocation','allocations.delivery_code','=','delivery_items.delivery_code')
         ->OrderBy('delivery.id','DESC')
         ->simplePaginate($this->perPage);
      $count = 1;
        return view('livewire.customers.allocations-tracking', ['allocations'=>$allocations, 'counts'=>$count]);
    }
}
