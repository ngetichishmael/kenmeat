<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;

class ChatsController extends Controller
{


    public function index()
    {
    // $admin = Auth::user();

    //     $messages = Message::where(function ($query) use ($admin) {
    //         $query->where('recipient_id', $admin->id);
    //     })
    //     ->orWhere(function ($query) use ($admin) {
    //         $query->where('sender_id', $admin->id);
    //     })
    //     ->orderBy('created_at', 'asc')
    //     ->with('response')
    //     ->get();

    $pageConfigs = [
        'pageHeader' => false,
        'contentLayout' => "content-left-sidebar",
        'pageClass' => 'chat-application',
    ];

    return view('livewire.chats.layout',['pageConfigs' => $pageConfigs]);
    }

    // public function index()
    // {
    //     return view('livewire.customersupport.dashboard');
    // }

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeResponse(Request $request, Message $message)
    {
        $admin = Auth::user();
    
        $response = new Response([
            'message_id' => $message->id,
            'response' => $request->input('response')
        ]);
    
        $response->save();
    
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    // }

    public function show($id)
    {
        $message = Message::with('responses')->find($id);
        $unreadMessages = Message::where('read_at', null)->count();
        $sender = $message->sender;
    
        // Get all messages sent by the sender of the current message
        $senderMessages = Message::where('sender_id', $sender->id)->where('id', '<', $message->id)->get();
    
        // Get all responses for the sender messages
        $senderResponses = Response::whereIn('message_id', $senderMessages->pluck('id'))->get();
    
        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'chat-application',
        ];

        $unreadMessageSenders = Message::whereNull('read_at')
        ->pluck('sender_id')
        ->toArray();

        $latestReadMessageIds = Message::selectRaw('MAX(id) as id')
            ->whereNotNull('read_at')
            ->whereNotIn('sender_id', $unreadMessageSenders)
            ->groupBy('sender_id')
            ->get()
            ->pluck('id')
            ->toArray();

        $readmessages = Message::with('sender')
            ->whereIn('id', $latestReadMessageIds)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        $messages = Message::with('sender')
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.chats.show', [
            'message' => $message,
            'messages' => $messages,
            'readmessages' => $readmessages,
            'unreadMessages' => $unreadMessages,
            'senderMessages' => $senderMessages,
            'senderResponses' => $senderResponses,
            'pageConfigs' => $pageConfigs
        ]);
    }
    

    public function update(Request $request, $id)
    {
        $message = Message::find($id);

        $response = new Response();
        $response->message_id = $id;
        $response->response = $request->input('response');
        $response->save();
        
        $message->read_at = now();
        $message->save();

        return redirect()->route('ChatSupport')->with('success', 'Response has been sent to the user successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $message = Message::with('responses')->find($id);
        
        // Get the sender of the current message
        $sender = $message->sender;
        
        // Get all messages sent by the sender along with their responses
        $senderMessages = Message::with('responses')
            ->where('sender_id', $sender->id)
            ->get();

        $pageConfigs = [
            'pageHeader' => false,
            'contentLayout' => "content-left-sidebar",
            'pageClass' => 'chat-application',
        ];

        $unreadMessageSenders = Message::whereNull('read_at')
        ->pluck('sender_id')
        ->toArray();

        $latestReadMessageIds = Message::selectRaw('MAX(id) as id')
            ->whereNotNull('read_at')
            ->whereNotIn('sender_id', $unreadMessageSenders)
            ->groupBy('sender_id')
            ->get()
            ->pluck('id')
            ->toArray();

        $readmessages = Message::with('sender')
            ->whereIn('id', $latestReadMessageIds)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        
        $messages = Message::with('sender')
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.chats.showview', [
            'message' => $message,
            'messages' => $messages,
            'readmessages' => $readmessages,
            
            'senderMessages' => $senderMessages,
           
            'pageConfigs' => $pageConfigs
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {

    }

}

