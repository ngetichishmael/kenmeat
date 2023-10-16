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
            'next_step_for_customer' => 'nullable|string',
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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/images/responses'), $imageName);
        } else {
            $imageName = null; 
        }

        
        $validatedData = array_merge($request->all(), [
            'user_id' => $request->user()->id,
            'checking_code' => $checking_code,
            'customer_id' => $customer_id,
            'image' => $imageName, // Store the image name in the database

        ]);

        
    

        $formResponse = FormResponse::create($validatedData);

        return response()->json([
            'message' => 'Form response submitted successfully.',
            'data' => $formResponse,
        ]);
    }
}
