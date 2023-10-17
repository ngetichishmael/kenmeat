<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchandiserController extends Controller
{
    public function index()
    {
        return view('livewire.merchandiser.layout');

    }
}
