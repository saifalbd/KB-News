<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $user = User::find($this->data['user_id']);
        $user->load('avatar');
    
        return [
            'id'=>$this->id,
            'type'=>Str::afterLast($this->type, '\\'),
            'data'=>$this->data,
            'fromUser'=>$user,
            'read_at'=>$this->read_at,
            'atNow'=>$this->created_at->diffForHumans(null,null,true)
        ];
    }
}
