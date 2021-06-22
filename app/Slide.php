<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Slide extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'es_title',
        'es_caption',
        'es_description_short',
        'en_title',
        'en_caption',
        'en_description_short',
        'link',
        'image'
    ];

    public function getImageAttribute() {
        return !empty($this->attributes['image']) ? json_decode($this->attributes['image']) : NULL;
    }

    public function getImageUrlAttribute() {
        return $this->image ? env('APP_URL') . Storage::url($this->image->path) : NULL;
    }
}
