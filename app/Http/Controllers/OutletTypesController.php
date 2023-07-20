<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutletTypeRequest;
use App\Models\OutletType;
use Illuminate\Http\Response;
use Illuminate\View\View;

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

}
