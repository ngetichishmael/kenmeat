<?php

namespace App\Http\Controllers\app;

use App\Helpers\StockLiftHelper;
use App\Models\inventory\items;
use App\Models\products\product_inventory;
use App\Models\RequisitionProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\inventory\allocations;

class inventoryController extends Controller
{
   //allocated
   public function allocated(){
      return view('app.inventory.allocated');
   }
   public function approval()
   {
      return view('app.inventory.approving');
   }

   //allocate user
   public function allocate_user(Request $request){
      $code = Str::random(20);
      $item = new allocations;
      $item->business_code = Auth::user()->business_code;
      $item->allocation_code = $code;
      $item->sales_person = $request->sales_person;
      $item->date_allocated = date("Y-m-d");
      $item->status = 'Waiting acceptance';
      $item->created_by = Auth::user()->user_code;
      $item->save();

      Session()->flash('success','Allocate products to sales person');

      return redirect()->route('inventory.allocate.items',$code);
   }

   //allocate items
   public function allocate_items($code){
      return view('app.inventory.allocate_items', compact('code'));
   }
   public function approve($id){
      return view('app.inventory.approve_items', compact('id'));
   }

   public function handleApproval(Request $request)
   {
      $selectedProducts = $request->input('selected_products', []);
      $user = $request->user();
      $user_code = $user->user_code;
      $business_code = $user->business_code;
      $random = Str::random(20);
      if (empty($selectedProducts)) {
         session()->flash('Error','Not products selected');
         return redirect('warehousing/all/stock-requisition');
      }else{
         foreach ($selectedProducts as $productId) {
            $product = RequisitionProduct::find($productId);
            if ($product) {
               if ($product->approval === 1){
                  session()->flash('error','Products already allocated to sales person');
                  return redirect('warehousing/all/stock-requisition');
               }
               if ($request->has('approve')) {

                  $image_path = 'image/92Ct1R2936EUcEZ1hxLTFTUldcSetMph6OGsWu50.png';
                  $value = [
                     'productID' => $product->product_id,
                     'qty' => $product->quantity,
                  ];

                     $stock = items::where('product_code', $value["productID"])
                        ->where('created_by', $user_code)
                        ->pluck('product_code')
                        ->implode('');
                     if ($stock == null) {
                        $stocked = product_inventory::find($product->product_id);
//                        $stocked = product_inventory::where('productID', $value["productID"])->first();
//                        dd($value["productID"]);
                      items::create([
                           'business_code' => $business_code,
                           'allocation_code' => $random,
                           'product_code' => $value["productID"],
                           'current_qty' => $stocked["current_stock"],
                           'allocated_qty' => $value["qty"],
                           'image' => $image_path,
                           'returned_qty' => 0,
                           'created_by' => $user_code,
                           'updated_by' => $user_code,
                        ]);
                     } else {

                        $inventoryallocation = DB::table('inventory_allocated_items')
                           ->where('product_code', $value["productID"])
                           ->increment('allocated_qty', $value["qty"]);
                     }
                     DB::table('product_inventory')
                        ->where('productID', $value["productID"])
                        ->decrement('current_stock', $value["qty"]);
                  }
                 allocations::create([
                     "business_code" => $business_code,
                     "allocation_code" => $random,
                     "sales_person" => $user_code,
                     "status" => "Waiting acceptance",
                     "created_by" => $user_code,
                     "created_by" => $user_code,

                  ]);
                  $product->update(['approval' => 1]);
               } elseif ($request->has('disapprove')) {
                  $product->update(['approval' => 0]);
                  items::where('product_code', $product->productID)
                     ->decrement('allocated_qty', $product->quantity);

                  product_inventory::where('productID', $product->productID)
                     ->increment('current_stock', $product->quantity);
                  //product_inventory::whereId($productId)->increment('current_stock', $product->quantity);
               }
            }
      }
      session()->flash('success','Allocated products to sales person');
      return redirect('warehousing/all/stock-requisition');
   }
}
