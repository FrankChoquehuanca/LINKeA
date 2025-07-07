<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\User;
use Livewire\Attributes\On;

class ChatInterface extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $selectedUser = null;
    public $users = [];

    public function mount()
    {
        // Obtener usuarios con los que se ha conversado
        $this->users = User::where('id', '!=', auth()->id())
            ->with(['sentMessages', 'receivedMessages'])
            ->get()
            ->filter(function($user) {
                return $user->sentMessages->count() > 0 ||
                       $user->receivedMessages->count() > 0;
            });
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if ($this->selectedUser) {
            $this->messages = Message::where(function($query) {
                    $query->where('sender_id', auth()->id())
                          ->where('receiver_id', $this->selectedUser->id);
                })
                ->orWhere(function($query) {
                    $query->where('sender_id', $this->selectedUser->id)
                          ->where('receiver_id', auth()->id());
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }
    }

    public function sendMessage()
    {
        if ($this->newMessage && $this->selectedUser) {
            Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $this->selectedUser->id,
                'content' => $this->newMessage,
            ]);

            $this->newMessage = '';
            $this->loadMessages();
        }
    }

    #[On('echo:chat.{selectedUser.id},MessageSent')]
    public function messageReceived($payload)
    {
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat-interface');
    }
}
