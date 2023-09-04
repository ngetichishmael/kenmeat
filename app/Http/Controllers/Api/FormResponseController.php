<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormResponseController extends Controller
{
    public function store(Request $request, $customer_id, $checking_code)
    {
        $validator = Validator::make($request->all(), [
            'interested_in_new_order' => 'required|string|in:Yes,No',
            'stock_replenishment' => 'nullable|string',
            'expiry_date_update' => 'nullable|date_format:Y-m-d',
            'pricing_accuracy' => 'required|string|in:Yes,No',
            'incorrect_pricing_product_name' => 'nullable|string',
            'incorrect_pricing_current_price' => 'nullable|string',
            'product_visible' => 'required|string|in:Yes,No',
            'progress_status' => 'required|string|in:Very poor,Average,Good,Very Good',
            'new_insights' => 'nullable|string',
            'product_visible' => 'required|string|in:Yes,No',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $validatedData = array_merge($request->all(), [
            'user_id' => $request->user()->id,
            'checking_code' => $checking_code,
            'customer_id' => $customer_id,
        ]);

        // Handle image upload if exists
        $imagePath = null;
        if ($request->hasFile('placement.image')) {
            $imagePath = $request->file('placement.image')->store('images', 'public');
        }
        $validatedData['placement']['image'] = $imagePath;
        
        $formResponse = FormResponse::create($validatedData);

        return response()->json([
            'message' => 'Form response submitted successfully.',
            'data' => $formResponse,
        ]);
    }
}
