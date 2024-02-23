<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException;


use App\Http\Requests\OutletTypeRequest;
use App\Models\OutletType;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class OutletTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response | View
    {
        return view('livewire.outlet.index');
    }

    public function show(OutletType $outlet)
    {
        return view('livewire.outlet.show', compact('outlet'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(OutletTypeRequest $request)
    {
        OutletType::create($request->validated());

        Session()->flash('success', "Outlet successfully added");
        return redirect()->back();
    }


    public function edit($outletCode): View
    {
        $outletType = OutletType::where('outlet_code', $outletCode)->firstOrFail();
        
        return view('livewire.outlet.edit', compact('outletType'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  OutletTypeRequest  $request
     * @param  OutletType  $outletType
     * @return \Illuminate\Http\Response
     */


     public function update(OutletTypeRequest $request, $outletCode): RedirectResponse
     {
         try {
             $outletType = OutletType::where('outlet_code', $outletCode)->firstOrFail();
             
             $outletType->update($request->validated());
     
             session()->flash('success', 'Outlet successfully updated');

             return redirect()->route('outlets');
             
         } catch (ModelNotFoundException $exception) {

             abort(404, 'Outlet not found');
         }
     }
     
     


}
