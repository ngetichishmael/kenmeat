<?php

namespace App\Http\Controllers\app;

use App\Helpers\SMS;
use App\Http\Controllers\Controller;
use App\Models\AppPermission;
use App\Models\Area;
use App\Models\Region;
use App\Models\suppliers\suppliers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    function list() {
        // $lists = User::whereIn('account_type', ['Admin', 'Manager'])
        //    ->distinct('account_type')
        //    ->whereNotIn('account_type', ['Customer'])
        //    ->groupBy('account_type')
        //    ->pluck('account_type');
        // $count = 1;
        return view('app.users.usertypes');
    }
    public function index()
    {
        return view('app.users.usertypes');
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
            "regions" => $regions,
        ]);
    }
    public function creatensm()
    {
        // $routes = array_merge($regions, $subregions, $zones);
        $regions = Region::all();
        $routes = Area::all();
        return view('app.users.creatensm', [
            "routes" => $routes,
            "regions" => $regions,
        ]);
    }
    //store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email|email|unique:users,email',
            'name' => 'required',
            'phone_number' => 'required',
            'account_type' => 'required',
        ]);

        if ($validator->fails()) {
            // If validation fails, redirect back with error messages and old input
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

      if ($validator->fails()) {
         return redirect()->back()
             ->withErrors($validator)
             ->withInput();
     }

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
                "route_code" => 1,
                "region_id" => 1,
                "status" => 'Active',
                "password" => Hash::make($request->phone_number),
                "business_code" => FacadesAuth::user()->business_code,

            ]
        );
        if ($request->phone_number) {
            $message = "Your data has been updated login with " . $request->phone_number . ' and new password is ' . $request->phone_number;
            if (in_array($request->account, ['Admin', 'Manager'])) {
                $message = "Your  data has been updated login with " . $request->email . ' and new password is ' . $request->phone_number;
            }
            (new SMS())($request->phone_number, $message);
        }
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
        Session()->flash('success', 'User Created Successfully');
        return redirect('/users');

    }

    //edit
    public function edit($user_code)
    {
        $edit = User::where('user_code', $user_code)
            ->where('business_code', FacadesAuth::user()->business_code)
            ->first();

        $permissions = AppPermission::where('user_code', $user_code)->first();
        if ($permissions == null) {
            $permissions = AppPermission::updateOrCreate(
                [
                    "user_code" => $edit->user_code,

                ],
                [
                    "van_sales" => "NO",
                    "new_sales" => "NO",
                    "schedule_visits" => "NO",
                    "deliveries" => "NO",
                    "merchanizing" => "NO",
                ]
            );
        }
        $regions = Region::all();

        return view('app.users.edit', [
            'edit' => $edit,
            'user_code' => $user_code,
            'permissions' => $permissions,
            'regions' => $regions,
        ]);
    }

    //edit
    public function view($user_code)
    {
        $edit = User::where('user_code', $user_code)
            ->where('business_code', FacadesAuth::user()->business_code)
            ->first();

        $permissions = AppPermission::where('user_code', $user_code)->first();
        if ($permissions == null) {
            $permissions = AppPermission::updateOrCreate(
                [
                    "user_code" => $edit->user_code,

                ],
                [
                    "van_sales" => "NO",
                    "new_sales" => "NO",
                    "schedule_visits" => "NO",
                    "deliveries" => "NO",
                    "merchanizing" => "NO",
                ]
            );
        }
        $regions = Region::all();

        return view('app.users.view', [
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
                "region_id" => 1,
                "route_code" => 1,

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

        return redirect()->route('users.index');
    }
    public function import()
    {
        abort(403, "This action is Limited to Admin Only");
    }

    public function admin()
    {
        $admin = User::where('account_type', 'Admin');
        return view('app.users.admin', compact('admin'));
    }

    public function tsr()
    {
        $tsr = User::where('account_type', 'Sales');
        return view('app.users.tsr', compact('tsr'));
    }

    public function ac()
    {
        $ac = User::where('account_type', 'Account Manager');
        return view('app.users.accountmanager', compact('ac'));
    }
    public function Merchandizer()
    {
        $Merchandizer = User::where('account_type', 'Merchandizer');
        return view('app.users.Merchandizer', compact('Merchandizer'));
    }
    public function hr()
    {
        $hr = User::where('account_type', 'HR');
        return view('app.users.hr', compact('hr'));
    }
    public function rsm()
    {
        $rsm = User::where('account_type', 'Manager');
        return view('app.users.rsm', compact('rsm'));
    }

    public function HorecaSales()
    {
        $HorecaSales = User::where('account_type', 'Horeca Sales');
        return view('app.users.horecasales', compact('HorecaSales'));
    }

    public function GTSales()
    {
        $GTSales = User::where('account_type', 'GT Sales');
        return view('app.users.gtsales', compact('GTSales'));
    }
}
