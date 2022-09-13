<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\UserAnalytic;
use App\Models\UserFavorite;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    public $timestamps = false;

    protected $fillable = [
        'email_or_number' , 'verification_code'
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

    
    public function customCreate($data)
    {
        $uid = User::create([ 'email_or_number' => $data['email_or_number'] ])->id;

        foreach($data['history'] as $h)
            UserHistory::create([ 'user_id' => $uid , 'product_id' => $h ]);

        
        foreach($data['favorites'] as $f)
            UserFavorite::create([ 'user_id' => $uid , 'product_id' => $f ]);

        
        foreach($data['analytics'] as $a)
            UserAnalytic::create([ 'user_id' => $uid , 'product_id' => $a ]);
    }
}
