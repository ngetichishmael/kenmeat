<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ChatsCountController extends Controller
{
    public function index(Request $request)
    {
        $unreadMessages = Message::where('read_at', null)->count();

        return View::make('partials._head_nav')->with('unreadMessages', $unreadMessages);
    }
}
