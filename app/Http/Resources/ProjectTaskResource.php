<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectTaskResource extends JsonResource
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
            'attachments'=>AttachResource::collection($this->attachments),
            'title'=>$this->title,
            'description'=>$this->description,
            'start'=>$this->start,
            'end'=>$this->end,
            'employees'=>AuthResource::collection($this->employees),
            'status'=>$this->status?$this->status:0,
        ];
    }
}
