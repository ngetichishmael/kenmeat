<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Activity;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Cart;
use App\Models\customer\checkin;
use App\Models\customer\customers;
use App\Models\Delivery;
use App\Models\Delivery_items;
use App\Models\Orders;
use App\Models\Order_items;
use App\Models\order_payments;
use App\Models\Region;
use App\Models\Routes;
use App\Models\Route_customer;
use App\Models\Subregion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * @group Customers Api's
 *
 * APIs to manage the Customers
 * */
class customersController extends Controller
{
    /**
     * Customer list
     *
     * @param $businessCode
     * @queryParam page_size int size per page. Default to 20
     **/
    public function index(Request $request, $businessCode)
    {
        $user = $request->user();

        $route_code = $request->user()->route_code;
        $region = Region::whereId($route_code)->first();
        $subregion = Subregion::where('region_id', $region->id)->pluck('id');
        $areas = Area::whereIn('subregion_id', $subregion)->pluck('id');

        $query = customers::get();

        $defaultImageUrl = asset('images/no-image.png');

        // Modify the image URLs
        foreach ( $query as $customer) {
            $imageFileName = $customer->image;
            $imagePath = public_path('storage/' . $imageFileName);
            $imageUrl = file_exists($imagePath) ? asset('storage/' . $imageFileName) : $defaultImageUrl;

            $customer->image = $imageUrl;
        }

        return response()->json([
            "user" => $user,
            "success" => true,
            "message" => "Customer List",
            "data" => $query,
        ]);
    }

    /**
     * Customer details
     *
     * @param int $id this is the customer unique code
     **/
    public function details($id)
    {
        $customer = customers::find($id);

        return response()->json([
            "success" => true,
            "message" => "Customer List",
            "data" => $customer,
        ]);
    }
    public function add_customer(Request $request)
    {
        //   $user_code = $request->user()->user_code;
        $validator = Validator::make($request->all(), [
            "customer_name" => "required",
            "contact_person" => "required",
            "business_code" => "required",
            "created_by" => "required",
            "latitude" => "required",
            "longitude" => "required",
            "image" => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "status" => 401,
                    "message" =>
                    "validation_error",
                    "errors" => $validator->errors(),
                ],
                403
            );
        }
        $image_path = $request->file('image')->store('image', 'public');
        $emailData = $request->email == null ? null : $request->email;

        $customer = new customers;
        $customer->customer_name = $request->customer_name;
        $customer->contact_person = $request->contact_person;
        $customer->phone_number = $request->phone_number;
        $customer->email = $emailData;
        $customer->address = $request->address;
        $customer->latitude = $request->latitude;
        $customer->longitude = $request->longitude;
        $customer->business_code = $request->business_code;
        $customer->created_by = $request->user()->user_code;
        $customer->route_code = $request->route_code;
        $customer->customer_group = $request->outlet;
        $customer->region_id = $request->route_code;
        $customer->unit_id = $request->route_code;
        $customer->image = $image_path;
        $customer->save();

        DB::table('leads_targets')
            ->where('user_code', $request->user()->user_code)
            ->increment('AchievedLeadsTarget');
        (new Activity)(
            "Registered new customner by " . $customer->customer_name,
            "Customer",
            'Registration',
            $request->user()->id,
            $request->user()->user_code,
            $request->ip() ?? "127.0.0.1",
            "App"
        );

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer added successfully",
        ]);
    }

    public function editCustomer(Request $request)
    {
        $customer = customers::whereId($request->id)->first();

        $edited = customers::whereId($request->id)->update(
            [
                "customer_name" => $request->customer_name ?? $customer->customer_name,
                "account" => $request->account ?? $customer->account,
                "address" => $request->address ?? $customer->address,
                "latitude" => $request->latitude ?? $customer->latitude,
                "longitude" => $request->longitude ?? $customer->longitude,
                "contact_person" => $request->contact_person ?? $customer->contact_person,
                "customer_group" => $request->customer_group ?? $customer->customer_group,
                "price_group" => $request->price_group ?? $customer->price_group,
                "route" => $request->route ?? $customer->route,
                "region_id" => $request->route ?? $customer->route,
                "unit_id" => $request->route ?? $customer->route,
                "approval" => 'Approved' ?? $customer->approval,
                "status" => 'Active' ?? $customer->status,
                "telephone" => $request->telephone ?? $customer->telephone,
                "manufacturer_number" => $request->manufacturer_number ?? $customer->manufacturer_number,
                "vat_number" => $request->vat_number ?? $customer->vat_number,
                "delivery_time" => $request->delivery_time ?? $customer->delivery_time,
                "city" => $request->city ?? $customer->city,
                "province" => $request->province ?? $customer->province,
                "postal_code" => $request->postal_code ?? $customer->postal_code,
                "country" => $request->country ?? $customer->country,
                "customer_secondary_group" => $request->customer_secondary_group ?? $customer->customer_secondary_group,
                "branch" => $request->branch ?? $customer->branch,
                "email" => $request->email ?? $customer->email,
                "phone_number" => $request->phone_number ?? $customer->phone_number,
                "business_code" => $request->user()->business_code ?? $customer->business_code,
                "created_by" => $request->user()->id ?? $customer->id,
            ]
        );

        (new Activity)(
            "Edit customner by name " . $edited->customer_name,
            "Customer",
            'Edit',
            $request->user()->id,
            $request->user()->user_code,
            $request->ip() ?? "127.0.0.1",
            "App"
        );

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer editted successfully",
            "customer" => $edited,
        ]);
    }
    public function calculate_distance(Request $request)
    {
        $id = $request->user()->id;
        $customer = customers::where('account', $request->customer)->first();
        $lat1 = $customer->latitude;
        $lon1 = $customer->longitude;
        $lat2 = $request->latitude;
        $lon2 = $request->longitude;
        $unit = "K";

        $distance = round(Helper::distance($lat1, $lon1, $lat2, $lon2, $unit), 2);

        // if($distance < 0.05){

        //create a check in session
        $checkin = new checkin();
        $checkin->code = Helper::generateRandomString(20);
        $checkin->customer_id = $customer->id;
        $checkin->account_number = $request->customer;
        $checkin->checkin_type = $this->checkVisit($id, $customer->id);
        $checkin->user_code = Auth::user()->user_code;
        $checkin->ip = Helper::get_client_ip();
        $checkin->start_time = date('H:i:s');
        $checkin->stop_time = date('H:i:s');
        $checkin->business_code = Auth::user()->business_code;
        $checkin->save();

        //recorord activity
        $activities = '<b>' . Auth::user()->name . '</b> Has <b>Checked-in</b> to <i> ' . $customer->customer_name . '</i> @ ' . date('H:i:s');
        $section = 'Customer';
        $action = 'Checkin';
        $business_code = Auth::user()->business_code;
        $activityID = $checkin->code;

        Helper::activity($activities, $section, $action, $activityID, $business_code);

        return redirect()->route('customer.checkin', $checkin->code);

        // }else{
        //    Session::flash('warning','You are not near the customer shop');
        //    return redirect()->back();
        // }

    }

    public function checkVisit($user_id, $customer_id)
    {

        $today = Carbon::today()->format('Y-m-d');
        $visit = null;
        $checker = Routes::with([
            'RouteSales' => function ($query) use ($user_id) {
                $query->where('userID', $user_id);
            },
        ])
            ->where('start_date', '>', $today)
            ->where('end_date', '<', $today)
            ->pluck('route_code');
        if ($checker !== null) {
            $route_customer = Route_customer::whereIn('routeID', $checker)->where('customer_id', $customer_id)->get();
            if ($route_customer !== null) {
                $visit = "Admin";
            }
        }
        return $visit;
    }
    /**
     * Customer deliveries
     *
     * @param string $customerID this is the customer ID
     * @param string $business_code this is the Business code
     **/
    public function deliveries($customerID, $business_code)
    {
        $delivery = Delivery::where('customer', $customerID)->where('business_code', $business_code)->orderby('id', 'desc')->get();

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer Deliveries",
            "data" => $delivery,
        ]);
    }

    /**
     * Customer deliveries
     *
     * @param string $code this is the delivery unique code
     **/
    public function delivery_details($code)
    {
        $delivery = Delivery::where('delivery_code', $code)->first();

        //      $products = Delivery_items::join('product_information','product_information.id','=','delivery_items.productID')
        //                               ->where('delivery_code',$code)
        //                             ->get();

        $products = Delivery_items::join('product_price', 'product_price.productID', '=', 'delivery_items.productID')
            ->select('*', DB::raw('(selling_price * allocated_quantity) as total_amount'))
            ->where('delivery_code', $code)
            ->get();
        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer added successfully",
            "delivery" => $delivery,
            "products" => $products,
        ]);
    }

    /**
     * Customer Orders
     *
     * @param string $customerID this is the customer ID
     **/
    public function orders($customerID)
    {
        $orders = Orders::where('customerID', $customerID)->orderby('orders.id', 'desc')->get();

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer orders",
            "orders" => $orders,
        ]);
    }

    /**
     * Order details
     *
     * @param string $orderCode this is the order code
     **/
    public function order_details($orderCode)
    {
        $order = Orders::where('order_code', $orderCode)->first();
        $items = Order_items::where('order_code', $orderCode)->get();
        $orders = Cart::where('order_code', $orderCode)->get();
        $payment = order_payments::where('order_id', $orderCode)->get();
        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Customer orders",
            "order_items" => $orders,
            "items" => $items,
            "Data" => $order,
            "Payment" => $payment,
        ]);
    }
    public function creditorStatus()
    {

    }

    /**
     * New orders
     *
     * @param string $customerID this is the customer ID
     **/
    public function new_order($customerID)
    {
        $orders = Orders::where('customerID', $customerID)
            ->where('order_status', 'Pending Delivery')
            ->orderby('orders.id', 'desc')->get();

        return response()->json([
            "success" => true,
            "status" => 200,
            "message" => "Pending Delivery",
            "Data" => $orders,
        ]);
    }
}
