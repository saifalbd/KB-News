<?php

namespace App\Events;


use Illuminate\Broadcasting\InteractsWithBroadcasting;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class RemoveComment implements ShouldBroadcast
{
    use InteractsWithBroadcasting;

    public $comment_id;
 

    public function __construct( $comment_id)
    {
        $this->comment_id =$comment_id;
        $this->broadcastVia('pusher');
    }

    public function broadcastOn()
    {
        return new PresenceChannel('commentRemove.'.$this->comment_id);
    }

    public function broadcastWith()
    {

        return [
            'id'=>$this->comment_id
        ];
        
    }
}