<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent2 implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;



    public $sender;
    public $message;
    public $receviver;
    public $conversation;

    public function __construct(Doctor $sender, Message $message, Patient $receviver, Conversation $conversation)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->conversation = $conversation;
        $this->receviver = $receviver;
    }

    public function broadcastWith()
    {
        return [
            'sender_email' => $this->sender->email,
            'receviver_email' => $this->receviver->email,
            'message' => $this->message->id,
            'conversation_id' => $this->conversation->id,
        ];
    }
    public function broadcastOn()
    {
        return new PrivateChannel('chat2.' . $this->receviver->id);
    }
}
