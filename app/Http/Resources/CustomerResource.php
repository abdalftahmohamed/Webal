<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
//            'bank_name_en' => $this->bank_name['en'],
//            'bank_name_ar' => $this->bank_name['ar'],
            'bank_name' => $this->bank_name,
            'Image' => url('attachments/banks/'.$this->id.'/'. $this->image_path),
            'bank_information' => $this->bank_information,
            'bank_phone' => $this->bank_phone,
            'bank_code' => $this->bank_code,
            'status' => $this->status,
            'bank_address' => $this->bank_address,
            'products'=>ProductResource::collection($this->products),
            'employees'=>TeamResource::collection($this->employees)
        ];
    }

}
