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
            'video Title' => $this->video_title,
            'video Description'=>$this->video_description,
            'simple Description'=>$this->simple_description,
            'Image' => url('attachments/trainningVideo/'.$this->id.'/'. $this->image),
            'Video' => url('attachments/trainningVideo/'.$this->id.'/'. $this->video),
        ];
    }
}
