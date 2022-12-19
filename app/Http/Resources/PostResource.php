<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'owner'=>$this->user->name ?? 'Unknown User',
            'title'=>$this->title,
            'description'=>$this->description,
            'category'=>$this->category->name ?? 'Unknown Category'
        ];
    }
}
