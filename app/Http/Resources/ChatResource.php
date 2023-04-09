<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'join_id'=>$this->join_id,
            'sender_id'=>$this->sender_id,
            'receiver_id'=>$this->receiver_id,
            'message'=>$this->message?$this->message:'',
            'attach'=>$this->attach?new AttachResource($this->attach):null,
            'atNow'=>$this->created_at->diffForHumans(null,null,true)
        ];
    }
}
