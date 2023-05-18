<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AppPermission;
use App\Models\Region;
use Exception;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class usersController extends Controller
{
   //list
   public function index()
   {
      return view('app.users.index');
   }
   public function indexUser()
   {
      return view('app.users.import');
   }

   //create
   public function create()
   {
      // $routes = array_merge($regions, $subregions, $zones);
      $routes = Region::all();
      return view('app.users.create', [
         "routes" => $routes
      ]);
   }
   public function sendOTP($number, $code)
   {

      try {
         $curl = curl_init();

         curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://prsp.jambopay.co.ke/api/api/org/disburseSingleSms/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "number" : "' . $number . '",
                "sms" : ' . $code . ',
                "callBack" : "https://....",
                "senderName" : "PASANDA"
          }
          ',
            CURLOPT_HTTPHEADER => array(
               'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwYXlsb2FkIjp7ImlkIjozNywibmFtZSI6IkRldmVpbnQgTHRkIiwiZW1haWwiOiJpbmZvQGRldmVpbnQuY29tIiwibG9jYXRpb24iOiIyMyBPbGVuZ3VydW9uZSBBdmVudWUsIExhdmluZ3RvbiIsInBob25lIjoiMjU0NzQ4NDI0NzU3IiwiY291bnRyeSI6IktlbnlhIiwiY2l0eSI6Ik5haXJvYmkiLCJhZGRyZXNzIjoiMjMgT2xlbmd1cnVvbmUgQXZlbnVlIiwiaXNfdmVyaWZpZWQiOmZhbHNlLCJpc19hY3RpdmUiOmZhbHNlLCJjcmVhdGVkQXQiOiIyMDIxLTExLTIzVDEyOjQ5OjU2LjAwMFoiLCJ1cGRhdGVkQXQiOiIyMDIxLTExLTIzVDEyOjQ5OjU2LjAwMFoifSwiaWF0IjoxNjQ5MzEwNzcxfQ.4y5XYFbC5la28h0HfU6FYFP5a_6s0KFIf3nhr3CFT2I',
               'Content-Type: application/json'
            ),
         ));

         $response = curl_exec($curl);

         curl_close($curl);
      } catch (Exception $e) {
      }
   }

   //store
   public function store(Request $request)
   {
      $this->validate($request, [
         'email' => 'required|unique:users,email',
         'name' => 'required',
         'phone_number' => 'required',
         'account_type' => 'required',
         'employee_code' => 'required',
         'route' => 'required',
      ]);

      $user_code = $request->employee_code;

      // Save user
      User::updateOrCreate(
         ["user_code" => $user_code],
         [
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "name" => $request->name,
            "account_type" => $request->account_type,
            "email_verified_at" => now(),
            "route_code" => $request->route,
            "status" => 'Active',
            "password" => $request->password === null ? Hash::make('password') : Hash::make($request->password),
            "business_code" => FacadesAuth::user()->business_code,
         ]
      );

      // Update or create app permissions
      $van_sales = $request->van_sales == null ? "NO" : "YES";
      $new_sales = $request->new_sales == null ? "NO" : "YES";
      $deliveries = $request->deliveries == null ? "NO" : "YES";
      $schedule_visits = $request->schedule_visits == null ? "NO" : "YES";
      $merchandizing = $request->merchandizing == null ? "NO" : "YES";

      AppPermission::updateOrCreate(
         ["user_code" => $user_code],
         [
            "van_sales" => $van_sales,
            "new_sales" => $new_sales,
            "schedule_visits" => $schedule_visits,
            "deliveries" => $deliveries,
            "merchandizing" => $merchandizing,
         ]
      );

      session()->flash('success', 'User Created Successfully');
      return redirect()->route('users.index');
   }

   public function edit($id)
   {
      $permissions = array();
      $edit = User::whereId($id)->first();
      $permissions = AppPermission::where('user_code', $edit->user_code)->first();
      if ($permissions == null) {
         $permissions = AppPermission::Create(
            [
               "user_code" => $edit->user_code,
               "van_sales" => "NO",
               "new_sales" => "NO",
               "schedule_visits" => "NO",
               "deliveries" => "NO",
               "merchanizing" => "NO",
            ]
         );
      }

      return view('app.users.edit', [
         'edit' => $edit,
         'user_code' => $edit->user_code,
         'permissions' => $permissions
      ]);
   }

   //update
   public function update(Request $request, $user_code)
   {
      $user = User::where('user_code', '=', $user_code)->first();
      User::updateOrCreate(
         [
            "user_code" => $user_code,
         ],
         [
            "email" => $request->email ?? $user->email,
            "phone_number" => $request->phone_number ?? $user->phone_number,
            "name" => $request->name ?? $user->name,
            "account_type" => $request->account_type ?? $user->account_type,
            "status" => 'Active',
            "password" => $request->password === null ? $user->password : Hash::make($request->password),

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
   public function destroy($id)
   {
      User::where('id', $id)->delete();
      Session()->flash('success', 'User deleted Successfully');
      return redirect()->route('users.index');
   }
   public function import()
   {
      abort(403, "This action is Limited to Admin Only");
   }
}
