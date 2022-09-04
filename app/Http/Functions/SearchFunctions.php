<?php

namespace App\Http\Functions;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryBrand;
use App\Models\ProductCategory;

class SearchFunctions {

    public static function ConfigQueryParams($query, $defaults) 
    {
        $params = $defaults;

        foreach($defaults as $key => $val)
            $params[$key] = isset($query[$key]) ? $query[$key] : $val;

        return $params;
    }

    public static function SuggestCategoriesBySearchedText($text, $justSubCategories = false) {
        
    }

    public static function GetBrandsInSearch($text) {
        $firstProduct = Product::where('title','LIKE', "%$text%")->take(1)->get();

        if( count($firstProduct) == 0 || $firstProduct[0]->brand_id == null ) return [];
        
        $productBrand = Brand::find($firstProduct[0]->brand_id);
        $brandCategory = CategoryBrand::where('brand_id', '=', $productBrand->id)->take(1)->get();
        $brandsIDs = CategoryBrand::where('category_id', '=', $brandCategory[0]->category_id)->get('brand_id');

        $brands = [];
        foreach($brandsIDs as $bid) {
            $brands[] = Brand::find($bid);
        }

        return $brands;
    }

}