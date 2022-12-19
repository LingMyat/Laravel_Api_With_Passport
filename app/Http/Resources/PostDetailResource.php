<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'Created_at'=>$this->created_at->format('Y/m/d H:iA'),
            'Created_at_readable'=>Carbon::parse($this->created_at)->diffForHumans(),
            'Owner_name'=>$this->user->name ?? 'Unknown Owner',
            'Category_name'=>$this->category->name ?? 'Unknown Category',
            'Title'=>$this->title,
            'Description'=>$this->description,
            'Image'=>asset($this->image->file_name ??'Unknown Image'),
        ];
    }
}
