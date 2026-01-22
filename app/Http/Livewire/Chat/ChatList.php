<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chatlist extends Component
{

    public $conversations;
    public $auth_email;
    public $auth_guard;
    public $receviverUser;
    public $selected_conversation;
    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh'];


    public function mount()
    {
        $this->auth_email = auth()->user()->email;
        $this->auth_guard = Auth::getDefaultDriver();
    }

    public function getUsers(Conversation $conversation, $request)
    {
        if ($this->auth_guard == 'patient') {
            // لو المريض هو اللى فاتح وهو اللى باعت الرسائل
            if ($conversation->sender_email == $this->auth_email) {
                $this->receviverUser = Doctor::firstWhere('email', $conversation->receiver_email);
            }
            // لو المريض هو اللى فاتح وهو اللى مستقبل الرسائل
            else {
                $this->receviverUser = Doctor::firstWhere('email', $conversation->sender_email);
            }
        }
        // لو الدكتور هو اللى فاتح وهو اللى باعت الرسائل
        elseif ($this->auth_guard == 'doctor') {
            if ($conversation->sender_email == $this->auth_email) {
                $this->receviverUser = Patient::firstWhere('email', $conversation->receiver_email);
            }
            // لو الدكتور هو اللى فاتح وهو اللى مستقبل الرسائل
            else {
                $this->receviverUser = Patient::firstWhere('email', $conversation->sender_email);
            }
        }

        if (isset($request)) {
            return $this->receviverUser->$request;
        }
    }


    public function chatuserselected(Conversation $conversation, $receviver_id)
    {
        $this->selected_conversation = $conversation;
        $this->receviverUser = Doctor::find($receviver_id);
        if (Auth::guard('patient')->check()) {
            $this->emitTo('chat.chat-box', 'load_conversation_doctor',  $this->selected_conversation, $this->receviverUser);
            $this->emitTo('chat.send-message', 'updateMessage', $this->selected_conversation, $this->receviverUser);
        } else {
            $this->emitTo('chat.chat-box', 'load_conversation_patient',  $this->selected_conversation, $this->receviverUser);
            $this->emitTo('chat.send-message', 'updateMessage2', $this->selected_conversation, $this->receviverUser);
        }
    }


    public function render()
    {
        $this->conversations = Conversation::where('sender_email', $this->auth_email)->orwhere('receiver_email', $this->auth_email)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('livewire.chat.chat-list');
    }
}
