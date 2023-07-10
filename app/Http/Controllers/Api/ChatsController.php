<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Activity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Message;
use App\Models\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
   public function index()
   {
      $user = Auth::user();
      $admin = User::where('account_type', 'Admin')->first();

      $messages = Message::where(function ($query) use ($user, $admin) {
         $query->where('sender_id', $user->id)
            ->where('recipient_id', $admin->id);
      })
         ->orWhere(function ($query) use ($user, $admin) {
            $query->where('sender_id', $admin->id)
               ->where('recipient_id', $user->id);
         })
         ->latest()
         ->with('response')
         ->get();

      $messages->each(function ($message) use ($user) {
         if ($message->recipient_id == $user->id && !$message->read_at) {
            $message->update(['read_at' => now()]);
         }
      });

      return response()->json($messages);
   }





   public function store(Request $request)
   {
      $user = Auth::user();
      $admin = User::where('account_type', 'Admin')->first();

      $message = new Message([
         'sender_id' => $user->id,
         'recipient_id' => $admin->id,
         'message' => $request->input('message')
      ]);
      (new Activity)(
         "Sent a message" . $message->message,
         "SMS",
         'Sent',
         $user->id,
         $user->user_code,
         $request->ip() ?? null,
         "App",
      );
      $message->save();

      return response()->json([
         "success" => true,
         "status" => 200,
         'message' => 'Message sent.'
      ]);
   }
}
