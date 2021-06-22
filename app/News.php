<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'es_title',
        'es_caption',
        'es_description',
        'es_long_text',
        'en_title',
        'en_caption',
        'en_description',
        'en_long_text',
        'image',
        'share_url'
    ];

    public function users_model() {
        return $this->belongsToMany('App\User')->withPivot('created_at AS suscription_date');
    }

    public function getImageAttribute() {
        return !empty($this->attributes['image']) ? json_decode($this->attributes['image']) : NULL;
    }

    public function getImageUrlAttribute() {
        return $this->image ? env('APP_URL') . Storage::url($this->image->path) : NULL;
    }
}
