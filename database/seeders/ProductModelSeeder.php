<?php

namespace Database\Seeders;

use App\Models\ProductModel;
use Illuminate\Database\Seeder;

class ProductModelSeeder extends Seeder
{
    public function run()
    {
        ProductModel::create([ 'name' => 'Huawei Y9a' ]);
    }
}
