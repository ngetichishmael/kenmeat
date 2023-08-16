<?php

namespace App\Http\Livewire\Productapproval;

use App\Models\status;
use Livewire\Component;
use App\Models\warehousing;
use Illuminate\Support\Str;
use App\Models\activity_log;
use Illuminate\Http\Request;
use App\Models\StockRequisition;
use App\Models\RequisitionProduct;
use App\Models\products\product_inventory;
use App\Models\products\product_information;

class approve_item extends Component
{

   public $product_id;

   public function render()
   {
      $products = RequisitionProduct::where('requisition_id', $this->product_id)->with('ProductInformation')->get();
      $warehouseCodes = $products->pluck('product_information.warehouse_code');
      $warehouses = Warehousing::whereIn('warehouse_code', $warehouseCodes)->get();
      return view('livewire.productapproval.approve', [
         'products' => $products,
         'requisition_id' => $this->product_id,
         'warehouses' => $warehouses,
      ]);
   }
   public function handleApproval(Request $request)
   {
      $selectedProducts = $request->input('selected_products', []);

      foreach ($selectedProducts as $productId) {
         $product = RequisitionProduct::find($productId);

         if ($product) {
            if ($request->has('approve')) {
               $product->update(['approval' => 1]);
               product_inventory::whereId($productId)->decrement('current_stock', $product->quantity);
            } elseif ($request->has('disapprove')) {
               $product->update(['approval' => 0]);
               product_inventory::whereId($productId)->increment('current_stock', $product->quantity);
            }
         }
      }

      return redirect('/warehousing/approve/' . $product->requisition_id);
   }


   public function approve(Request $request)
   {
      $selectedProducts = $request->input('selected_products', []);

      foreach ($selectedProducts as $productId) {
         $requisitionProduct = RequisitionProduct::findOrFail($productId);
         $requisitionProduct->update(['approval' => 1]);

         product_inventory::whereId($productId)->decrement(
            'current_stock',
            $requisitionProduct->quantity
         );
      }

      $requisitionId = $request->input('requisition_id');
      return redirect('/warehousing/approve/' . $requisitionId);
   }

   public function disapprove(Request $request)
   {
      $selectedProducts = $request->input('selected_products', []);

      foreach ($selectedProducts as $productId) {
         $requisitionProduct = RequisitionProduct::findOrFail($productId);
         $requisitionProduct->update(['approval' => 0]);

         product_inventory::whereId($productId)->increment(
            'current_stock',
            $requisitionProduct->quantity
         );
      }
      // $random = Str::uuid();
      // $activityLog = new activity_log();
      // $activityLog->activity = 'Stock Approval';
      // $activityLog->user_code = auth()->user()->user_code;
      // $activityLog->section = 'Stock Approved ';
      // $activityLog->action = 'Stock requisition  Successfully Approved  ';
      // $activityLog->userID = auth()->user()->id;
      // $activityLog->activityID = $random;
      // $activityLog->source = 'Web';
      // $activityLog->ip_address = $request->ip() ?? '';
      // $activityLog->save();

      $requisitionId = $request->input('requisition_id');
      return redirect('/warehousing/approve/' . $requisitionId);
   }


   //   public function approve(Request $request)
   //   {
   //      $selectedProducts = $request->input('selected_products', []);
   //
   //      foreach ($selectedProducts as $productId) {
   //         $requisitionProduct = RequisitionProduct::find($productId);
   //         if ($requisitionProduct) {
   //            $requisitionProduct->update(['approval' => 1]);
   //
   //            product_inventory::whereId($productId)->decrement(
   //               'current_stock',
   //               $requisitionProduct->quantity
   //            );
   //         }
   //      }
   //
   //      return redirect('/warehousing/approve/'.$requisitionProduct->requisition_id);
   //   }
   //
   //   public function disapprove(Request $request)
   //   {
   //      $selectedProducts = $request->input('selected_products', []);
   //
   //      foreach ($selectedProducts as $productId) {
   //         $requisitionProduct = RequisitionProduct::find($productId);
   //         if ($requisitionProduct) {
   //            $requisitionProduct->update(['approval' => 0]);
   //
   //            product_inventory::whereId($productId)->increment(
   //               'current_stock',
   //               $requisitionProduct->quantity
   //            );
   //         }
   //      }
   //
   //      return redirect('/warehousing/approve/'.$requisitionProduct->requisition_id);
   //   }



   //   public function approve($id)
   //   {
   //      $re=RequisitionProduct::whereId($id)->update(
   //         [
   //            'approval' => 1
   //         ]
   //      );
   //      $products = RequisitionProduct::whereId($this->product_id)->get();
   //      foreach ($products as $product) {
   //         product_inventory::whereId($this->product_id)->decrement(
   //            'current_stock',
   //            $product->quantity
   //         );
   //      }
   //
   //      return redirect('/warehousing/approve/'.$this->requisition_id);
   //   }
   //   public function disapprove($id)
   //   {
   //      $re=RequisitionProduct::whereId($id)->update(
   //         [
   //            'approval' => 0
   //         ]
   //      );
   //      $products = RequisitionProduct::whereId($this->product_id)->get();
   //      foreach ($products as $product) {
   //         product_inventory::whereId($this->product_id)->increment(
   //            'current_stock',
   //            $product->quantity
   //         );
   //      }
   //      return redirect('/warehousing/approve/'.$this->requisition_id);
   //   }
}
