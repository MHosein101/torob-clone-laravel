<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\UserAnalytic;
use App\Models\UserFavorite;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;

    protected $fillable = [
        'email_or_number' , 'verification_code'
    ];
    
    protected $casts = [];

    public function generateAuthToken()
    {
        $this->verification_code = null;
        $this->api_token = Str::random(60);
        $this->save();
        return $this;
    }

    
    public static function customCreate($data)
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
