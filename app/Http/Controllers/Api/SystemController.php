<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppVersion;


class SystemController extends Controller
{
    public function getAppVersion()
    {
        try {
            $appVersion = AppVersion::latest()->first();
    
            if ($appVersion) {
                return response()->json([
                    'success' => true,
                    'message' => 'App Version',
                    'version' => $appVersion->version
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'App Version not found',
                    'version' => null
                ], 404); // Return a 404 Not Found status code
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving app version',
                'version' => null
            ], 500); // Return a 500 Internal Server Error status code
        }
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
