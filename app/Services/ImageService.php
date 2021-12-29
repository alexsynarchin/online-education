<?php


namespace App\Services;
use Image;
use Storage;
use Carbon\Carbon;

class ImageService
{
 public function make($image, $directory)
 {
     $imageData = $image;
     Storage::makeDirectory('/public/'.$directory);
     $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
     Image::make($image)->save(storage_path('app/public/').$directory . $fileName);
     return $fileName;
 }
}
