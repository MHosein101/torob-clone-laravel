<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    use HasFactory;

    public static function createWithProductUpdate($data)
    {
        $p = Product::where('id', '=', $data['product_id'])->update([
            'marked_as_favorite' => DB::raw('marked_as_favorite + 1')
        ]);

        Favorite::create($data);
    }

}
