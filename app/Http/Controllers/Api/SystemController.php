<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppVersion;


class SystemController extends Controller
{
    public function getAppVersion()
    {
        $appVersion = AppVersion::latest()->first();
    
        return response()->json([
            'success' => true,
            'message'=> 'App Version',
            'version' => $appVersion ? $appVersion->version : null]);
    }
    
    public function storeAppVersion(Request $request)
    {
        $request->validate([
            'version' => 'required|string',
        ]);
    
        $appVersion = AppVersion::create([
            'version' => $request->input('version'),
        ]);
    
        return response()->json($appVersion, 201);
    }
    
}
