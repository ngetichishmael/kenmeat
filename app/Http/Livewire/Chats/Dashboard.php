<?php

namespace App\Http\Livewire\Chats;

use Livewire\Component;

use App\Models\Message;

class Dashboard extends Component
{
    public $unreadMessages;
    public $messages;
    public $readmessages;
    public $showResponseForm = false;
    public $selectedMessage;

    public function showResponseForm($messageId)
{
    $this->showResponseForm = true;
    $this->selectedMessage = Message::findOrFail($messageId);
}


    public function mount()
    {
        $this->messages = Message::with('sender')
        ->whereNull('read_at')
        ->orderByDesc('created_at')
        ->get();

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

        $this->readmessages = Message::with('sender')
            ->whereIn('id', $latestReadMessageIds)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $this->unreadMessages = Message::where('read_at', null)->count();

    }

    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->read_at = now();
        $message->save();

        $this->messages = $this->messages->except($id);
    }

    public function render()
    {
        return view('livewire.chats.dashboard', [
            'messages' => $this->messages,
            'readmessages' => $this->readmessages,
        ]);
    }
}
