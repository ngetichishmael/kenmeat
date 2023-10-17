<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckinsController extends Controller
{
    public function index()
    {
        return view('livewire.checkins.layout');

    }
}
