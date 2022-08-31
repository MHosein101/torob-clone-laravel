<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email' , 'validatoin_code'
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [];

    
    public function generateAuthToken()
    {
        $this->api_token = Str::random(60);
        return $this;
    }
}
