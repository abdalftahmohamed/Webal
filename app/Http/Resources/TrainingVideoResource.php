<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingVideoResource extends JsonResource
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
            'video_title' => $this->video_title,
            'video_description'=>$this->video_description,
            'simple_description'=>$this->simple_description,
            'video' => url('attachments/trainningVideo/'.$this->id.'/'. $this->video),
            'image' => url('attachments/trainningVideo/'.$this->id.'/'. $this->image),
        ];
    }
}
