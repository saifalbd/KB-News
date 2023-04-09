<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'text'=>$this->text,
            'parent_id'=>$this->parent_id,
            'reactCount'=>$this->react_count,
            'reacts'=>$this->reacts->map(function($react){
                return [
                    'prop'=>$react->prop,
                    'id'=>$react->user->id,
                    'name'=>$react->user->name,
                ];
            }),
            'atNow'=>$this->created_at->diffForHumans(),
            'user'=>[
                'id'=>$this->user->id,
                'name'=>$this->user->name,
                'avatar'=>$this->user->avatar? new AttachResource($this->user->avatar):null
            ],
            'attachments'=>$this->attachments->map(function($attach){
                return [
                    'id'=>$attach->id,
                    'isImg'=>$this->isImg,
                    'url'=>$this->url
                ];
            }),
            'replayes'=>static::collection($this->replayes)
        ];
    }
}
