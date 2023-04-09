<?php

namespace App\Events;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithBroadcasting;

class ChatEvent implements ShouldBroadcast
{
    use InteractsWithBroadcasting;

    public $chat;
    public $auth_id;

    public function __construct($chat, $auth_id)
    {
        $this->chat = $chat;
        $this->auth_id = $auth_id;
        $this->broadcastVia('pusher');
    }

    public function broadcastOn()
    {
        return new PresenceChannel('chat');
    }

   

    public function broadcastWith()
    {

        return $this->chat;
    }
}
