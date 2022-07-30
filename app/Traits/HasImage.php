<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImage
{

    public function storeImage(UploadedFile $new_image, string $directory = 'images'){
        //dd($directory);
        $image =new Image(['path' => $new_image -> store($directory, 'public')]);
        // $this -> image() -> save($image);
        $this -> image() -> save($image);
    }


    public function updateImage(UploadedFile $new_image, string $directory = 'images')
    {
        $previous_image = $this->image;

        if($previous_image){

            $previous_image_path = $previous_image -> path;
            $previous_image -> path = $new_image -> store($directory, 'public');
            $previous_image -> save();

            Storage::disk('public') -> delete($previous_image_path);
        }
        else{
            //dd("hola");
            //dd($new_image);
            $this->storeImage($new_image, $directory);
        }
        
    }



    private function deletePreviousImage(string $previous_image)
    {
        Storage::disk('public') -> delete($previous_image);
    }


    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}