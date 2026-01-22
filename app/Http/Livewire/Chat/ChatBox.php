<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{
    protected $listeners = ['load_conversation_doctor', 'load_conversation_patient', 'pushMessage'];
    public $receviverUser;
    public $messages;
    public $selected_conversation;
    public $auth_email;
    public $auth_id;
    public $event_name;
    public $chat_page;

    public function mount()
    {
        if (Auth::guard('patient')->check()) {
            $this->auth_email = Auth::guard('patient')->user()->email;
            $this->auth_id = Auth::guard('patient')->user()->id;
        } else {
            $this->auth_email = Auth::guard('doctor')->user()->email;
            $this->auth_id = Auth::guard('doctor')->user()->id;
        }
    }

    public function getListeners()
    {
        if (Auth::guard('patient')->check()) {
            $auth_id = Auth::guard('patient')->user()->id;
            $this->event_name = "MessageSent2";
            $this->chat_page = "chat2";
        } else {
            $auth_id = Auth::guard('doctor')->user()->id;
            $this->event_name = "MessageSent";
            $this->chat_page = "chat";
        }

        return [
            "echo-private:$this->chat_page.{$auth_id},$this->event_name" => 'broadcastMessage',
            'load_conversation_doctor',
            'load_conversation_patient',
            'pushMessage'
        ];
    }

    public function pushMessage($message_id)
    {
        $new_message = Message::find($message_id);
        $this->messages->push($new_message);
    }

    public function broadcastMessage($event)
    {
        $broadcastMessage = Message::find($event['message']);
        $broadcastMessage->read = 1;
        $this->pushMessage($broadcastMessage->id);
    }



    public function load_conversation_doctor(Conversation $conversation, Doctor $receiver)
    {
        $this->selected_conversation = $conversation;
        $this->receviverUser = $receiver;
        $this->messages = Message::where('conversation_id', $this->selected_conversation->id)->get();
    }


    public function load_conversation_patient(Conversation $conversation, Patient $receiver)
    {
        $this->selected_conversation = $conversation;
        $this->receviverUser = $receiver;
        $this->messages = Message::where('conversation_id', $this->selected_conversation->id)->get();
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
