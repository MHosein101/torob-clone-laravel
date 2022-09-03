<?php

namespace App\Http\Functions;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;

class SearchFunctions {

    public function ConfigQueryParams($query, $defaults) 
    {
        $params = $defaults;

        foreach($defaults as $key => $val)
            $params[$key] = isset($query[$key]) ? $query[$key] : $val;

        return $params;
    }

    public static function SuggestCategoriesBySearchedText($text) {
        $matchedProductsIDs = Product::where('title','LIKE', "%$text%")->take(20);
        
        $categoryIDs = ProductCategory::leftJoinSub($matchedProductsIDs, 'products_date', function ($join) {
            $join->on('product_categories.product_id', '=', 'products_date.id');
        })->select('category_id')->distinct()->get();

        $categories =[];

        foreach($categoryIDs as $cid)
            $categories[] = Category::find($cid)->first()->name;

        return $categories;
    }

}