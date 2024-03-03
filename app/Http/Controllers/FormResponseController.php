<?php

namespace App\Http\Controllers;

use App\Models\FormResponse;
use App\Http\Requests\StoreFormResponseRequest;
use App\Http\Requests\UpdateFormResponseRequest;
use App\Models\SalesStockLevel;


class FormResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFormResponseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormResponseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FormResponse  $formResponse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stockLevel = SalesStockLevel::with('producT')->findOrFail($id);
        return view('livewire.stock-level.show', compact('stockLevel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormResponse  $formResponse
     * @return \Illuminate\Http\Response
     */
    public function edit(FormResponse $formResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormResponseRequest  $request
     * @param  \App\Models\FormResponse  $formResponse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormResponseRequest $request, FormResponse $formResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormResponse  $formResponse
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormResponse $formResponse)
    {
        //
    }
}
