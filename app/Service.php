<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'vip',
        'es_title',
        'es_description',
        'en_title',
        'en_description',
        'images',
        'icon',
        'share_url'
    ];

    public function getImagesAttribute() {
        return !empty($this->attributes['images']) ? json_decode($this->attributes['images']) : NULL;
    }

    public function getImageUrlAttribute() {
        return $this->images ? env('APP_URL') . Storage::url($this->images[0]->path) : NULL;
    }

    public function getIconAttribute() {
        return !empty($this->attributes['icon']) ? json_decode($this->attributes['icon']) : NULL;
    }

    public function getIconUrlAttribute() {
        return $this->icon ? env('APP_URL') . Storage::url($this->icon->path) : NULL;
    }
}
