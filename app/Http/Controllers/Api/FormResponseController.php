<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormResponseController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'interested_in_new_order' => 'required|string|in:Yes,No',
            'stock_replenishment' => 'nullable|string',
            'expiry_date_update' => 'nullable|date_format:Y-m-d',

            'pricing_accuracy' => 'required|string|in:Yes,No',
            'incorrect_pricing_product_name' => 'nullable|string',
            'incorrect_pricing_current_price' => 'nullable|string',

            'progress_status' => 'required|string|in:Very poor,Average,Good,Very Good',
            'new_insights' => 'nullable|string',
            'product_visible' => 'required|string|in:Yes,No',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Set the user_id from the authenticated user
        $validatedData = $request->all();
        $validatedData['user_id'] = $request->user()->id;

        // Handle image upload if exists
        if ($request->hasFile('placement.image')) {
            $image_path = $request->file('placement.image')->store('images', 'public');
            $validatedData['placement']['image'] = $image_path;
        } else {
            $validatedData['placement']['image'] = null;
        }

        $formResponse = FormResponse::create($validatedData);

        return response()->json([
            'message' => 'Form response submitted successfully.',
            'data' => $formResponse,
        ]);
    }
}
