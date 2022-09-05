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

    public static function SuggestSearchQuery($text) {
        $delimiters = [' ', '.', '-', ',', '|', '\\', '/', '(', ')'];
        $newText = str_replace($delimiters, $delimiters[0], $text);
        $searchedWords = explode($delimiters[0], $newText);

        $productsTitle = [];
        foreach($searchedWords as $s) {
            $matchedProducts = Product::where('title','LIKE', "%$s%")->take(20)->get('title');
            foreach($matchedProducts as $p)
                $productsTitle[] = $p->title;
        }
        
        $queries = [];
        foreach($productsTitle as $title) {
            $newTitle = str_replace($delimiters, $delimiters[0], $title);
            $words = explode($delimiters[0], $newTitle);
            
            foreach($words as $w) {
                foreach($searchedWords as $s) {
                    if( strpos( strtolower($w), strtolower($s) ) !== false )
                        $queries[] = $w; 
                }
            }
        }
        return array_reverse( array_unique($queries) );
    }

    public static function SuggestCategoriesInSearch($textOrData, $useData = false) {
        $queries = null;

        if($useData)
            $queries = $textOrData;
        else
            $queries = SearchFunctions::SuggestSearchQuery($textOrData);

        $foundProductsIDs = [];
        foreach($queries as $q) {
            $products = Product::where('title','LIKE', "%$q%")->take(10)->get();
            foreach($products as $p)
                $foundProductsIDs[] = $p->id;
        }
        $foundProductsIDs = array_unique($foundProductsIDs);
        if( count($foundProductsIDs) == 0 ) return;

        $categorIDs = [];
        foreach($foundProductsIDs as $pid) {
            $categories = ProductCategory::where('product_id', $pid)->get();
            foreach($categories as $c)
                $categorIDs[] = $c->category_id;
        }
        $categorIDs = array_unique($categorIDs);

        $topLevel = Category::find($categorIDs[0]);
        foreach($categorIDs as $cid) {
            if($c->level > $topLevel->level)
                $topLevel = $c;
        }
        $mainCategory = $topLevel;

        $topCategories = Category::where('parent_id', $mainCategory->id)->get();
        $suggestedCategories = [];

        foreach($topCategories as $category) {
            $suggestedCategories[] = $category;
            $subCategories = Category::where('parent_id', $category->id)->get();
            foreach($subCategories as $sc)
                $suggestedCategories[] = $sc;
        }

        return $suggestedCategories;
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