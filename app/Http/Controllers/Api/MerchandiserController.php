<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerchandiserReport;
use App\Models\MerchandiserStockLevel;
use App\Models\MerchandiserCompetitor;
use Illuminate\Support\Facades\Storage;

class MerchandiserController extends Controller
{

    public function storeData(Request $request) {
        // Assuming you have the data in your request
        $data = $request->all();

        // Validate and store the uploaded image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public'); // Store the image in the 'public' disk under the 'images' directory
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Image not provided'
            ], 400);
            
        }

        // Create a new MerchandiserReport entry
        $report = new MerchandiserReport([
            'user_id' => auth()->user()->id,
            'today_est_customers' => $data['today_est_customers'],
            'estimated_value' => $data['estimated_value'],
            'available_competitors' => $data['available_competitors'],
            'image' => $imagePath, // Save the image path in the database
        ]);

        $report->save();

        // Loop through stock levels and create entries
        foreach ($data['stock_levels'] as $stockData) {
            $stockLevel = new MerchandiserStockLevel([
                'product_id' => $stockData['product_id'],
                'stock_level' => $stockData['stock_level'],
                'expiration_date' => $stockData['expiration_date'],
            ]);

            $report->stockLevels()->save($stockLevel);
        }

        // Loop through competitors and create entries
        // foreach ($data['available_competitors'] as $competitorName) {
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
