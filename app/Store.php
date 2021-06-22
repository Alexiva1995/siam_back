<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Store extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'es_description_short',
        'es_description',
        'es_location',
        'en_description_short',
        'en_description',
        'en_location',
        'hour_from',
        'hour_to',
        'phone_number',
        'url',
        'images',
        'logo',
        'share_url'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function users_model() {
        return $this->belongsToMany('App\User')->withPivot('created_at AS fav_date');
    }

    public function getImagesAttribute() {
        return !empty($this->attributes['images']) ? json_decode($this->attributes['images']) : NULL;
    }

    public function getImagesUrlAttribute() {
        return $this->images ? array_map(function($image) {
            return env('APP_URL') . Storage::url($image->path);
        }, $this->images) : NULL;
    }

    public function getLogoAttribute() {
        return !empty($this->attributes['logo']) ? json_decode($this->attributes['logo']) : NULL;
    }

    public function getLogoUrlAttribute() {
        return $this->logo ? env('APP_URL') . Storage::url($this->logo->path) : NULL;
    }

    public function getHourFromAttribute() {
        $return = '';
        if ($this->attributes['hour_from'] && $this->attributes['hour_from'] < 1000) {
            $return = '0';
        }
        $return .= $this->attributes['hour_from'];
        return $return;
    }
    
    public function getHourToAttribute() {
        $return = '';
        if ($this->attributes['hour_to'] && $this->attributes['hour_to'] < 1000) {
            $return = '0';
        }
        $return .= $this->attributes['hour_to'];
        return $return;
    }
}
