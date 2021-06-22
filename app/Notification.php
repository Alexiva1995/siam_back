<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'es_title',
        'en_title',
        'es_body',
        'en_body',
        'link'
    ];
}
