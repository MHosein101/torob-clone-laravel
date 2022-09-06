<?php

namespace App\Http\Functions;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryBrand;
use App\Models\ProductCategory;

class SearchFunctions {

    /**
     * Replace default values in a parameter not set in queries
     *
     * @param query  query string of search config
     * @param default  default search config values
     * 
     * @return Object
     */ 
    public static function ConfigQueryParams($query, $defaults) 
    {
        $params = $defaults;

        foreach($defaults as $key => $val)
            $params[$key] = isset($query[$key]) ? $query[$key] : $val;

        return $params;
    }

    /**
     * Suggest search queries by text
     *
     * @param text text that user typed
     * 
     * @return StringArray
     */ 
    public static function SuggestSearchQuery($text) {

        if( $text == '' ) return []; // if no search text entered

        $delimiters = [' ', '.', '-', ',', '|', '\\', '/', '(', ')'];
         // replace $delimiters values with space in $text
        $newText = str_replace($delimiters, $delimiters[0], $text);
        // make an array of words from $text 
        $searchedWords = explode($delimiters[0], $newText);

        $productsTitle = [];
        // get title of products that matched the $searchedWords items
        foreach($searchedWords as $s) {
            $matchedProducts = Product::where('title','LIKE', "%$s%")->take(20)->get('title');
            foreach($matchedProducts as $p)
                $productsTitle[] = $p->title;
        }
        
        $queries = [];
        // search each $searchedWords in products title words, case insensitive, and get the matched ones
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

    /**
     * Suggest search queries by text
     *
     * @param textOrData text that user typed OR the queries data
     * @param useData to use queries data if already processed
     * 
     * @return CategoryArray
     */ 
    public static function SuggestCategoriesInSearch($textOrData, $useData = false) {
        $queries = null;

        if($useData)
            $queries = $textOrData;
        else {
            $queries = SearchFunctions::SuggestSearchQuery($textOrData);
            $queries[] = $textOrData;
        }

        // find products if they title matched one of queries
        $products = Product::select('id')->where('title','LIKE', "%{$queries[0]}%");//->take(24);
        $skipFirst = true;
        foreach($queries as $q) {
            if($skipFirst) { $skipFirst = false; continue; }
            $products = $products->orWhere('title','LIKE', "%$q%");
        }

        $products = $products->get();
        $foundProductsIDs = [];
        // get product ids that matched with each $queries
        foreach($products as $p)
            $foundProductsIDs[] = $p->id;
        
        $foundProductsIDs = array_unique($foundProductsIDs);
        if( count($foundProductsIDs) == 0 ) return []; // if no products matched

        $categorIDs = [];
        // get category ids of matched products
        foreach($foundProductsIDs as $pid) {
            $categories = ProductCategory::where('product_id', $pid)->get();
            foreach($categories as $c)
                $categorIDs[] = $c->category_id;
        }
        $categorIDs = array_unique($categorIDs);

        // find the first parent of found categories
        $topLevel = Category::find($categorIDs[0]);
        foreach($categorIDs as $cid) {
            $c = Category::find($cid);
            if($c->level < $topLevel->level)
                $topLevel = $c;
        }
        $mainCategory = $topLevel;

        // get first category children
        $topCategories = Category::where('parent_id', $mainCategory->id)->get();
        $suggestedCategories = [];

        // get first category children's sub categories
        foreach($topCategories as $category) {
            $subCategories = Category::where('parent_id', $category->id)->get();
            foreach($subCategories as $sc)
                $suggestedCategories[] = $sc;
        }

        return $suggestedCategories;
    }


    /**
     * Get brands of products that first matched in search
     *
     * @param text text that user typed
     * 
     * @return BrandArray
     */ 
    public static function GetBrandsInSearch($text) {
        $firstProduct = Product::where('title','LIKE', "%$text%")->take(1)->get(); // first matched product

        // if no result matched OR product has no brand
        if( count($firstProduct) == 0 || $firstProduct[0]->brand_id == null ) return [];
        
        $productBrand = Brand::find($firstProduct[0]->brand_id)->first(); // find brand
        $brandCategory = CategoryBrand::where('brand_id', $productBrand->id)->take(1)->get(); // find brand category
        $brandsIDs = CategoryBrand::where('category_id', $brandCategory[0]->category_id)->get('brand_id'); // get category brands ids

        $brands = [];
        // get brands
        foreach($brandsIDs as $bid)
            $brands[] = Brand::find($bid)->first();

        return $brands;
    }

}