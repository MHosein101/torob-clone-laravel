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
        'phone_number' , 'verification_code'
    ];
    
    protected $casts = [];

    public function generateVerificatioCode()
    {
        $nums = '0123456789';
        $code = '';
        foreach([0,1,2,3] as $i)
            $code .= ( $nums[ random_int( 0, strlen($nums)-1 ) ] );

        $this->verification_code = $code;
        $this->save();

        return $code;
    }

    public function generateApiToken()
    {
        $token = Str::random( random_int(50,70) );
        
        $this->verification_code = null;
        $this->api_token = $token;
        $this->save();

        return $token;
    }

    
    public static function customCreate($data)
    {
        $uid = User::create([ 'phone_number' => $data['phone_number'] ])->id;

        foreach($data['history'] as $h)
            UserHistory::create([ 'user_id' => $uid , 'product_id' => $h ]);

        
        foreach($data['favorites'] as $f)
            UserFavorite::create([ 'user_id' => $uid , 'product_id' => $f ]);

        
        foreach($data['analytics'] as $a)
            UserAnalytic::create([ 'user_id' => $uid , 'product_id' => $a ]);
    }
}
