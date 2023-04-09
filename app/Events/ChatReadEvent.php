<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatReadEvent implements ShouldBroadcast
{
    use InteractsWithBroadcasting;

    public $chat_id;

    public function __construct( $chat_id)
    {
        $this->chat_id = $chat_id;
        $this->broadcastVia('pusher');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chatread.'.$this->chat_id);
    }

    public function broadcastWith()
    {

        return [
            'chat_id'=>$this->chat_id
        ];
        
    }
}
