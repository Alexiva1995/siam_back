<?php
namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    protected $image_size = 600;

    public function resizeAndStore($image, $image_size = NULL) {
        $t = array_sum(explode(" ", microtime())) * 10000;

        if (empty($image_size)) $image_size = $this->image_size;

        try {
            if (is_array($image_size)) {
                $resize = Image::make($image)->fit($image_size[0], $image_size[1])->encode('jpg');
            } else {
                $resize = Image::make($image)->fit($image_size)->encode('jpg');
            }
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            return [];
        }
        $hash = md5($t);
        $path = "public/{$hash}.jpg";
        Storage::put($path, $resize);

        return [
            'hash' => $hash,
            'path' => basename($path),
            'name' => basename($path),
            'size' => Storage::size($path)
        ];
    }
}