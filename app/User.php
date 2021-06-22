<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use App\Notifications\MyResetPassword;
use Illuminate\Support\Facades\Storage;
use App\LinkedSocialAccount;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'admin',
        'card_number',
        'image',
        'birthdate',
        'phone_number',
        'address',
        'zip_code',
        'language'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function linkedSocialAccounts() {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new MyResetPassword($token));
    }

    public function getBirthdateAttribute() {
        return !empty($this->attributes['birthdate']) ? Carbon::parse($this->attributes['birthdate'])->format('d/m/Y') : NULL;
    }

    public function getOriginalBirthdateAttribute() {
        return $this->attributes['birthdate'];
    }

    public function getImageAttribute() {
        return !empty($this->attributes['image']) ? json_decode($this->attributes['image']) : NULL;
    }

    public function getImageUrlAttribute() {
        return $this->image ? env('APP_URL') . Storage::url($this->image->path) : NULL;
    }
}
