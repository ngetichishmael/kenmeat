<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockLevelController extends Controller
{
    public function index()
    {
       return view('livewire.stock-level.layout');
    }
}
