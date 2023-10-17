<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerchandiserReport;
use App\Models\MerchandiserStockLevel;
use App\Models\MerchandiserCompetitor;

class MerchandiserController extends Controller
{


    public function storeData(Request $request) {
        // Validate the request data, including the image upload
        $validatedData = $request->validate([
            'today_est_customers' => 'required|integer',
            'did_customer_make_order' => 'required|string|in:Yes,No',
            'estimated_value' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'stock_levels.*.product_id' => 'required|integer',
            'stock_levels.*.stock_level' => 'required|integer',
            'stock_levels.*.expiration_date' => 'required|date',
            'available_competitors' => 'required',
            // 'available_competitors.*' => 'string',
        ]);
    
        // Store the uploaded image in the "images" folder
        $imagePath = $request->file('image')->store('images', 'public');
    
        // Create a new MerchandiserReport entry
        $report = new MerchandiserReport([
            'user_id' => auth()->user()->id,
            'today_est_customers' => $validatedData['today_est_customers'],
            'estimated_value' => $validatedData['estimated_value'],
            'did_customer_make_order' => $validatedData['did_customer_make_order'],
            'available_competitors' => $validatedData['available_competitors'],
            'image' => $imagePath, // Store the image path in the database
        ]);
    
        $report->save();
    
        // Loop through stock levels and create entries
        foreach ($validatedData['stock_levels'] as $stockData) {
            $stockLevel = new MerchandiserStockLevel([
                'product_id' => $stockData['product_id'],
                'stock_level' => $stockData['stock_level'],
                'expiration_date' => $stockData['expiration_date'],
            ]);
    
            $report->stockLevels()->save($stockLevel);
        }
    
        // Loop through competitors and create entries
        // foreach ($validatedData['available_competitors'] as $competitorName) {
        //     $competitor = new MerchandiserCompetitor([
        //         'report_id' => $report->id,
        //         'name' => $competitorName,
        //     ]);
    
        //     $competitor->save();
        // }
    
        return response()->json([
            'success' => true,
            'message' => 'Report stored successfully',
        ]);
    }
    
}
