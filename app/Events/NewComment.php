<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithBroadcasting;

class NewComment implements ShouldBroadcast
{
    use InteractsWithBroadcasting;

    public $comment;
    public $name;

    public function __construct( $comment,string $name)
    {
        $this->comment =$comment;
        $this->name = $name;
        $this->broadcastVia('pusher');
    }

    public function broadcastOn()
    {
        return new PresenceChannel('comment.'.$this->name);
    }

    public function broadcastWith()
    {

        return $this->comment;
        
    }
}
