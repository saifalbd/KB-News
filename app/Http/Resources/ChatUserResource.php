<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatUserResource extends JsonResource
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
            'name'=>$this->name,
            'position'=>$this->designation?$this->designation->title:'boss',
            'lastMessage'=>$this->lastMessage,
            'avatar'=>$this->avatar?new AttachResource($this->avatar):null,
            'atNow'=>$this->updated_at->diffForHumans(null,null,true),
            'isOnline'=>$this->status,
            'unReadCount'=>$this->unReadCount

        ];
    }
}
