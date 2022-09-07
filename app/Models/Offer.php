<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    public function getIsAvailableAttribute($value)
    {
        return (boolean)$value;
    }
}
