<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrentDeviceInformationResource;
use App\Http\Resources\CurrentDeviceUseNamesResource;
use App\Http\Resources\UserLocationsResource;
use App\Models\CurrentDeviceInformation;
use App\Models\User;

class MapsUIController extends Controller
{
    public function getUserNames()
    {
        $user_codes = CurrentDeviceInformation::orderBy('id', 'DESC')->groupBy('user_code')->pluck('user_code');
        return response()->json([
            "data" => CurrentDeviceUseNamesResource::collection(User::whereIn('user_code', $user_codes)->get()),
        ]);
    }
    public function getCurrentCoordinates()
    {
        $information = CurrentDeviceInformation::with('user')->orderBy("id", "DESC")->groupBy("user_code")->get();
        return response()->json([
            'data' => CurrentDeviceInformationResource::collection($information),
        ]);
    }
    public function getCurrentLocation($id)
    {
        return response()->json([
            'data' => CurrentDeviceInformation::where('id', $id)->first(),
        ]);
    }
    public function getUserLocations($user_code)
    {
        return response()->json([
            'data' => UserLocationsResource::collection(
                CurrentDeviceInformation::with('user')->where('user_code', $user_code)->limit(25)->get()
            ),
        ]);

    }
}
