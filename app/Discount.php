<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Discount extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'vip',
        'es_title',
        'es_caption',
        'es_description',
        'en_title',
        'en_caption',
        'en_description',
        'date_from',
        'date_to',
        'images',
        'share_url'
    ];

    public function users_model() {
        return $this->belongsToMany('App\User')->withPivot('created_at AS fav_date');
    }

    public function getImagesAttribute() {
        return !empty($this->attributes['images']) ? json_decode($this->attributes['images']) : NULL;
    }

    public function getImageUrlAttribute() {
        return $this->images ? env('APP_URL') . Storage::url($this->images[0]->path) : NULL;
    }

    public function getDateFromAttribute() {
        return !empty($this->attributes['date_from']) ? Carbon::parse($this->attributes['date_from'])->format('d/m/Y') : NULL;
    }
    
    public function getDateToAttribute() {
        return !empty($this->attributes['date_to']) ? Carbon::parse($this->attributes['date_to'])->format('d/m/Y') : NULL;
    }

    public function getOriginalDateFromAttribute() {
        return $this->attributes['date_from'];
    }
    
    public function getOriginalDateToAttribute() {
        return $this->attributes['date_to'];
    }
}
