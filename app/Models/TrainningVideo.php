<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class TrainningVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'video',
        'video_title',
        'video_description',
        'simple_description',
    ];
    // protected $hidden=['image'];
//     protected $appends=[ 'image_url' ];
//     public function getImageUrlAttribute(){
//        if(!$this->image){
//            return'data:image/jpeg;base64,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';
//        }
//        if(Str::startsWith($this->image,['http://','http://'])){
//        }
//             return $this->image;
//   return asset('images' .$this->image);
//    }

}

