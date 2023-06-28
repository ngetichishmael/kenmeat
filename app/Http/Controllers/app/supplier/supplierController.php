<?php

namespace App\Http\Controllers\app\supplier;

use File;
use Wingu;
use Helper;
use App\Models\country;
use App\Models\lpo\lpo;
use Illuminate\Http\Request;
use App\Models\expense\expense;
use App\Models\invoice\invoices;
use App\Models\suppliers\category;
use App\Models\suppliers\comments;
use App\Models\suppliers\suppliers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\suppliers\contact_persons;
use App\Models\suppliers\supplier_address;
use App\Models\products\product_information;
use App\Models\suppliers\suppliers_categories;

class supplierController extends Controller
{

   public function __construct()
   {
      $this->middleware('auth');
   }

   public function index()
   {
      return view('app.suppliers.index');
   }
   public function show()
   {
      return view('app.suppliers.index');
   }

   public function create()
   {
      $country = country::OrderBy('id', 'DESC')->pluck('name', 'id')->prepend('Choose Country', '');
      $groups = category::where('business_code', Auth::user()->business_code)->OrderBy('id', 'DESC')->pluck('name', 'id');
      return view('app.suppliers.create', compact('country', 'groups'));
   }

   public function store(Request $request)
   {
      $this->validate($request, [
         'email' => 'required',
         'phone_number' => 'required',
      ]);

      $primary = new suppliers;
      $primary->email = $request->email;
      $primary->name = $request->name;
      $primary->phone_number = $request->phone_number;
      $primary->telephone = $request->telephone;
      $primary->status = $request->status;
      $primary->business_code = Auth::user()->business_code;
      $primary->save();

      Session::flash('success', 'Supplier has been successfully Added');

      return redirect()->route('supplier');
   }

   public function edit($id)
   {
      $country = country::OrderBy('id', 'DESC')->pluck('name', 'id')->prepend('Choose Country', '');
      $suppliers = suppliers::where('business_code', Auth::user()->business_code)
         ->where('suppliers.id', $id)
         ->first();
      //category
      $category = category::where('business_code', Auth::user()->business_code)->get();

      return view('app.suppliers.edit', compact('category', 'suppliers', 'country'));
   }

   public function update(Request $request, $id)
   {
      $this->validate($request, [
         'email' => 'required',
         'phone_number' => 'required',
      ]);

      $edit = suppliers::where('id', $id)->where('business_code', Auth::user()->business_code)->first();
      $edit->email = $request->email;
      $edit->name = $request->name;
      $edit->phone_number = $request->phone_number;
      $edit->telephone = $request->telephone;
      $edit->status = $request->status;
      $edit->business_code = Auth::user()->business_code;
      $edit->save();

      Session::flash('success', 'Supplier has been successfully updated');

      return redirect()->route('supplier');
   }

   //delete permanently
   public function delete($id)
   {
      suppliers::where('id',$id)->delete();
      Session::flash('success', 'Supplier has been successfully Deleted');
       
      return redirect()->route('supplier');
   }
}