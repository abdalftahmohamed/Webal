<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MagazineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'datesend' => $this->datesend,
            'author' => $this->author,
            'description'=>$this->description,
            'image' => url('storage/attachments/magazines/'.$this->id.'/'. $this->image),
        ];
    }
}
