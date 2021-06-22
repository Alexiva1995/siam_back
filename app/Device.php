<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'token',
        'device_type',
        'user_id'
    ];
}
