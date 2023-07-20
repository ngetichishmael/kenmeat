<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormResponse;
use Illuminate\Http\Request;

class FormResponseController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'nullable|string',
            'region_or_route' => 'nullable|string',
            'time_period' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
            'project_name' => 'nullable|string',
            'feedback_comments' => 'nullable|string',
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
