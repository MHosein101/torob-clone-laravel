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
     * @param take number of products to get
     * @param skip number of products to skip and ignore
     * 
     * @return StringArray
     */ 
    public static function SuggestSearchQuery($text, $take = 24, $skip = 0) {

        if( $text == '' ) return []; // if no search text entered

        $delimiters = [' ', '.', '-', ',', '|', '\\', '/', '(', ')'];
         // replace $delimiters values with space in $text
        $newText = str_replace($delimiters, $delimiters[0], $text);
        // make an array of words from $text 
        $searchedWords = explode($delimiters[0], $newText);

        $productsTitle = [];
        // get title of products that matched the $searchedWords items
        foreach($searchedWords as $s) {
            $matchedProducts = Product::where('title','LIKE', "%$s%")->take($take)->skip($skip)->get('title');
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
     * Limit the result of products sql query results with queries
     *
     * @param queries suggested search queries
     * @param product product sql query object
     * 
     * @return Product
     */ 
    public static function LimitProductsWithQueries($queries, $product) {
        $products = $product->where('title','LIKE', "%{$queries[0]}%");
        $skipFirst = true;
        foreach($queries as $q) {
            if($skipFirst) { $skipFirst = false; continue; }
            $products = $products->orWhere('title','LIKE', "%$q%");
        }
        return $product;
    }

    /**
     * Suggest search queries by text
     *
     * @param queries suggested search queries
     * @param sqlQuery if already have sql query to use
     * 
     * @return CategoryArray
     */ 
    public static function SuggestCategoriesInSearch($queries, $sqlQuery = null) {

        $products = null;
        if($sqlQuery == null) // make new sql search query
            $product = SearchFunctions::LimitProductsWithQueries($queries, Product::select('id'));
        else
            $products = $sqlQuery; // use ready query

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

            // if category has no child , add it to suggestion
            if( count($subCategories) == 0 ) 
                $suggestedCategories[] = $category;

            foreach($subCategories as $sc)
                $suggestedCategories[] = $sc;
        }

        return $suggestedCategories;
    }


    /**
     * Get brands of products that first matched in search
     *
     * @param product product sql query object
     * 
     * @return BrandArray
     */ 
    public static function GetBrandsInSearch($products) {
        $firstProduct = $products->take(1)->get();

        // if no result matched OR product has no brand
        if( count($firstProduct) == 0 || $firstProduct[0]->brand_id == null ) return [];
        
        $productBrand = Brand::find($firstProduct[0]->brand_id)->first(); // find brand
        $brandCategory = CategoryBrand::where('brand_id', $productBrand->id)->get()->first(); // find brand category
        $brandsIDs = CategoryBrand::where('category_id', $brandCategory->category_id)->get('brand_id'); // get category brands ids

        $brands = [];
        // get brands
        foreach($brandsIDs as $bid)
            $brands[] = Brand::find($bid)->first();

        return $brands;
    }

}