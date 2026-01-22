<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateChat extends Component
{

    public $users;
    public $auth_email;

    public function mount()
    {
        $this->auth_email = auth()->user()->email;
    }

    public function createConversation($receiver_email)
    {
        // البحث عن محادثة موجودة مسبقًا بين المرسل والمستقبل
        $existingConversation = Conversation::checkConversation($this->auth_email, $receiver_email)->first();

        if (!$existingConversation) {
            DB::beginTransaction();
            try {
                // إنشاء المحادثة
                $createConversation = Conversation::create([
                    'sender_email' => $this->auth_email,
                    'receiver_email' => $receiver_email,
                    'last_time_message' => now(),
                ]);

                // إنشاء أول رسالة
                Message::create([
                    'conversation_id' => $createConversation->id,
                    'sender_email' => $this->auth_email,
                    'receiver_email' => $receiver_email,
                    'body' => 'السلام عليكم',
                ]);

                DB::commit();
                return 'Conversation Created Successfully';
            } catch (\Exception $e) {
                DB::rollBack();
                return 'Error creating conversation';
            }
        } else {
            return dd('Conversation already exists');
        }
    }

    public function render()
    {

        if (Auth::guard('patient')->check()) {
            $this->users = Doctor::all();
        } else {
            $this->users = Patient::all();
        }

        return view('livewire.chat.create-chat')->extends('dashboard.layouts.master');
    }
}
