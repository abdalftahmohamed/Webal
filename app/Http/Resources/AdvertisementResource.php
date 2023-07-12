<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'description'=>$this->description,
            'image' => url('storage/attachments/advertisements/'.$this->id.'/'. $this->image),
            'video' => url('storage/attachments/advertisements/'.$this->id.'/'. $this->video),
        ];
    }
}
