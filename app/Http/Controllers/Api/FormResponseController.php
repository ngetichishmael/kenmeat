<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormResponse;
use Illuminate\Http\Request;

class FormResponseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|string',
            'customer_id' => 'nullable|string',
            'region_or_route' => 'nullable|string',
            'time_period' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_name' => 'nullable|string',
            'feedback_comments' => 'nullable|string',
            'available_products' => 'nullable|string',
            'out_of_stock_products' => 'nullable|string',
            'interested_in_new_order' => 'nullable|string',
            'stock_replenishment' => 'nullable|string',
            'expiry_date_update' => 'nullable|date_format:Y-m-d',
            'pricing_accuracy' => 'nullable|string',
            'incorrect_pricing_product_name' => 'nullable|string',
            'incorrect_pricing_current_price' => 'nullable|string',
            'progress_status' => 'nullable|string',
            'new_insights' => 'nullable|string',
            'product_visible' => 'nullable|string',
        ]);

        // Set the user_id from the authenticated user
        $validatedData['user_id'] = $request->user()->id;

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('images', 'public');
            $validatedData['image'] = $image_path;
        }

        $formResponse = FormResponse::create($validatedData);

        return response()->json([
            'message' => 'Form response submitted successfully.',
            'data' => $formResponse,
        ]);
    }
}
