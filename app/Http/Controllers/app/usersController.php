<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\activity_log;
use App\Models\Area;
use App\Models\suppliers\suppliers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AppPermission;
use App\Models\Region;
use Exception;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Str;

class usersController extends Controller
{
   public function getUsers(Request $request)
   {
      $accountType = $request->input('account_type');
      $users = User::where('account_type', $accountType)->get();

      return response()->json(['users' => $users]);
   }
   public function getDistributors(Request $request)
   {
      $distributors = suppliers::whereNotIn('name', ['Sokoflow', 'Sokoflow'])->orWhereNull('name')->orWhere('name', '')
         ->whereIn('status', ['Active', 'active'])
         ->orWhereNull('status')
         ->orWhere('status', '')
         ->get();

      return response()->json(['users' => $distributors]);
   }
   //list
   public function list()
   {
      $lists = User::whereIn('account_type', ['Admin', 'Manager'])
         ->distinct('account_type')
         ->whereNotIn('account_type', ['Customer'])
         ->groupBy('account_type')
         ->pluck('account_type');
      $count = 1;
      return view('app.users.list', compact('lists', 'count'));
   }
   public function index()
   {
      return view('app.users.index');
   }
   public function indexUser()
   {
      return view('app.users.import');
   }
   public function admins()
   {
      $admins = User::where('account_type', 'Admin');
      return view('app.users.admin', compact('admins'));
   }



   //create
   public function create()
   {
      // $routes = array_merge($regions, $subregions, $zones);
      $regions = Region::all();
      $routes = Area::all();
      return view('app.users.create', [
         "routes" => $routes,
         "regions" => $regions
      ]);
   }
   public function creatensm()
   {
      // $routes = array_merge($regions, $subregions, $zones);
      $regions = Region::all();
      $routes = Area::all();
      return view('app.users.creatensm', [
         "routes" => $routes,
         "regions" => $regions
      ]);
   }
   //store
   public function store(Request $request)
   {
      $this->validate($request, [
         'email' => 'required',
         'name' => 'required',
         'phone_number' => 'required',
         'account_type' => 'required',
         'region' => 'required',
      ]);
      $user_code = rand(100000, 999999);
      //save user
      $code = rand(100000, 999999);
      User::updateOrCreate(
         [
            "user_code" => $user_code,

         ],
         [
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "name" => $request->name,
            "account_type" => $request->account_type,
            "email_verified_at" => now(),
            "route_code" => $request->region,
            "region_id" => $request->region,
            "status" => 'Active',
            "password" => Hash::make($request->phone_number),
            "business_code" => FacadesAuth::user()->business_code,

         ]
      );
      $van_sales = $request->van_sales == null ? "NO" : "YES";
      $new_sales = $request->new_sales == null ? "NO" : "YES";
      $deliveries = $request->deliveries == null ? "NO" : "YES";
      $schedule_visits = $request->schedule_visits == null ? "NO" : "YES";
      $merchanizing = $request->merchanizing == null ? "NO" : "YES";
      AppPermission::updateOrCreate(
         [
            "user_code" => $user_code,

         ],
         [
            "van_sales" => $van_sales,
            "new_sales" => $new_sales,
            "schedule_visits" => $schedule_visits,
            "deliveries" => $deliveries,
            "merchanizing" => $merchanizing,
         ]
      );
      Session()->flash('success', 'User Created Successfully, Default Password is Phone_number');
      return redirect()->back();
   }

   //edit
   public function edit($user_code)
   {
      $edit = User::where('user_code', $user_code)
         ->where('business_code', FacadesAuth::user()->business_code)
         ->first();
      $permissions = AppPermission::where('user_code', $user_code)->firstOrFail();

      $regions = Region::all();

      return view('app.users.edit', [
         'edit' => $edit,
         'user_code' => $user_code,
         'permissions' => $permissions,
         'regions' => $regions,
      ]);
   }

   //update
   public function update(Request $request, $user_code)
   {
      $this->validate($request, [
         'email' => 'required',
         'name' => 'required',
         'phone_number' => 'required',
         'account_type' => 'required',
      ]);

      User::updateOrCreate(
         [
            "user_code" => $user_code,
            "business_code" => FacadesAuth::user()->business_code,
         ],
         [
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "name" => $request->name,
            "account_type" => $request->account_type,
            "status" => 'Active',
            "region_id" => $request->region,

         ]
      );
      $van_sales = $request->van_sales == null ? "NO" : "YES";
      $new_sales = $request->new_sales == null ? "NO" : "YES";
      $deliveries = $request->deliveries == null ? "NO" : "YES";
      $schedule_visits = $request->schedule_visits == null ? "NO" : "YES";
      $merchanizing = $request->merchanizing == null ? "NO" : "YES";
      AppPermission::updateOrCreate(
         [
            "user_code" => $user_code,
         ],
         [
            "van_sales" => $van_sales,
            "new_sales" => $new_sales,
            "schedule_visits" => $schedule_visits,
            "deliveries" => $deliveries,
            "merchanizing" => $merchanizing,
         ]
      );

      Session()->flash('success', 'User updated Successfully');

      return redirect()->back();
   }
   //   public function destroy($id)
   //   {
   //      User::where('id', $id)->delete();
   //      Session()->flash('success', 'User deleted Successfully');
   //      return redirect()->route('users.index');
   //   }
   public function import()
   {
      abort(403, "This action is Limited to Admin Only");
   }
}
