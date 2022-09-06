<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\CategoryBrand;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Functions\SearchFunctions;
use App\Http\Functions\CategoryFunctions;

class SearchController extends Controller
{

    /**
     * Suggest some search queries and categories by using a text that typed
     *
     * @param text  text that user typed
     * 
     * @return Json (Array of String , Array of Category)
     */ 
    public function suggestion(Request $request, $text)
    {
        $queries = SearchFunctions::SuggestSearchQuery($text);
        $categories = SearchFunctions::SuggestCategoriesInSearch($queries);

        return response()->json([
            'message' => 'Ok' ,
            'data' => [
                'suggested_queries' => $queries ,
                'suggested_categories' => $categories
            ]
        ], 200);
    }

    /**
     * Default search parameters if not included in search request
     * @var Object
     */
    private $defaultQueryParams = [
        'q' => null ,
        'category' => null ,
        'brand' => null ,
        'sort' => 'mostFavorite' , // dateRecent , priceMin , priceMax , mostFavorite
        'fromPrice' => 0 ,
        'toPrice' => 10000000000 ,
        'available' => false ,
        'page' => 1 ,
        'perPage' => 24
    ];

    /**
     * Search products
     *
     * @param query  query string data
     * 
     * @return Json (Object , Array of Product , Array of Brand , Array of Category)
     */ 
    public function search(Request $request)
    {
        $params = SearchFunctions::ConfigQueryParams($request->query(), $this->defaultQueryParams);

        if( $params["q"] == null && $params["category"] == null && $params["brand"] == null )
            return response()->json([
                'message' => 'Define at least one of this : search query or category or brand'
            ], 400);

        $searchQueryBuilder = null;
        $take = $params["perPage"];
        $skip = ( $params["page"] - 1 ) * $params["perPage"];

        $suggestedQueries = [];
        $searchCategories = [];
        $searchBrands = [];
        
        $searchQueryBuilder = $this->joinTables( Product::select('*') );

        if($params["q"] != null) { // if search query included 
            $suggestedQueries = SearchFunctions::SuggestSearchQuery($params["q"], $take, $skip); // suggest similar queries
            $searchQueryBuilder = $this->processTextQuery( $searchQueryBuilder, $suggestedQueries );
        }

        $data = $this->processCategory( $searchQueryBuilder , $params["category"] , $params["q"], $suggestedQueries );
        
        $searchQueryBuilder = $data[0];
        $searchCategories = $data[1];
        $searchBrands = $data[2];

        $data = $this->processBrand( $searchQueryBuilder , $params["brand"] , $searchCategories , $searchBrands );
        
        $searchQueryBuilder = $data[0];
        $searchCategories = $data[1];
        $searchBrands = $data[2];

        $searchQueryBuilder = $this->filterResults( $searchQueryBuilder , $request->query() , $params["fromPrice"] , $params["toPrice"] );

        // clone current sql query to get min and max product prices
        $productsPriceMin = clone $searchQueryBuilder;
        $productsPriceMax = clone $searchQueryBuilder;

        $searchQueryBuilder = $this->sortResults( $searchQueryBuilder , $params["sort"] );

        // make pagination from results
        $searchQueryBuilder = $searchQueryBuilder->skip($skip)->take($take);

        $searchResults = $searchQueryBuilder
        ->get(['id', 'title','image_url', 'price_start', 'shops_count']); // get selected values
        // ->get();

        $searchResults = $this->processResults( $searchResults );
        
        // get min and max product prices
        $productsPriceMin = $productsPriceMin->where('price_start', '!=', null)
                                             ->orderBy('price_start', 'asc')->take(1)->get();
        $productsPriceMax = $productsPriceMax->where('price_start', '!=', null)
                                             ->orderBy('price_start', 'desc')->take(1)->get();

        $priceRangeMin = 0;
        $priceRangeMax = 0;
        
         // set min and max product prices if any product found in search request
        if( count($productsPriceMin) > 0 && count($productsPriceMax) > 0 ) {
            $priceRangeMin = $productsPriceMin[0]->price_start;
            $priceRangeMax = $productsPriceMax[0]->price_start;
        }

        return response()->json([
            'message' => 'Ok' ,
            'data' => [
                'price_range' => [ 'min' => $priceRangeMin , 'max' => $priceRangeMax ] ,
                'brands' => $searchBrands ,
                'categories' => $searchCategories ,
                'products' => $searchResults
            ]
        ], 200);
    }

    /**
     * Join sql tables
     *
     * @param qbuilder  query builder object
     * 
     * @return Product
     */ 
    private function joinTables($qbuilder)
    {
        // favorites table sub sql
        $favorites = Favorite::selectRaw('product_id, COUNT(user_id) as favorites_count')
                             ->groupBy('product_id');

        // join with favorites sub sql to get each product favorite count
        $qbuilder = $qbuilder->leftJoinSub($favorites, 'product_favorites', function ($join) {
            $join->on('products.id', 'product_favorites.product_id');
        });
        
        // offers table sub sql
        $offers = Offer::selectRaw("product_id, MIN(price) as price_start, COUNT(shop_id) as shops_count")
                       ->where('is_available', true)
                       ->groupBy('product_id');
        
        // join with offers sub sql to get each available product least price
        $qbuilder = $qbuilder->leftJoinSub($offers, 'product_prices', function ($join) {
            $join->on('products.id', 'product_prices.product_id');
        });

        return $qbuilder;
    }

    /**
     * Process the searched text
     *
     * @param qbuilder query builder object
     * @param queries  suggested search queries
     * 
     * @return Product
     */ 
    private function processTextQuery($qbuilder, $queries)
    {
        $qbuilder = SearchFunctions::LimitProductsWithQueries($queries, $qbuilder);

        return $qbuilder;
    }

    /**
     * Process the searched text
     *
     * @param qbuilder  query builder object
     * @param category  category name
     * @param q  searched text
     * @param queries  suggested search queries
     * 
     * @return Array
     */ 
    private function processCategory($qbuilder, $category, $q, $queries)
    {
        $category = CategoryFunctions::Exists($category); // validate category name
        $searchCategories = [];
        $searchBrands = [];

        if($category) { // category name is valid

            // product categories table sub sql
            $categoryIDs = ProductCategory::where('category_id', $category->id)->select('product_id','category_id');

            // join with product categories sub sql to give each product its category id
            $qbuilder = $qbuilder->leftJoinSub($categoryIDs, 'product_category_ids', function ($join) {
                $join->on('products.id', 'product_category_ids.product_id');
            });

            $qbuilder = $qbuilder->where('category_id', $category->id); // filter by category

            $searchCategories = CategoryFunctions::GetSubCategoriesByName($category->name);
            $searchBrands = CategoryFunctions::GetBrandsInCategory($category->id);
        }
        else if($q)
            $searchCategories = SearchFunctions::SuggestCategoriesInSearch($queries, clone $qbuilder);

        return [ $qbuilder , $searchCategories , $searchBrands ];
    }

    /**
     * Process the searched text
     *
     * @param qbuilder  query builder object
     * @param category  category name
     * @param q  searched text
     * @param queries  suggested search queries
     * 
     * @return Array
     */ 
    private function processBrand($qbuilder, $brand, $searchCategories, $searchBrands)
    {
        $brand = SearchFunctions::BrandExists($brand);
        $searchBrands = [];

        if( $brand ) {
            $qbuilder = $qbuilder->where('brand_id', $brand->id); // filter by brand

            if( !$searchBrands ) { // if no category found in search
                $c = CategoryBrand::where('brand_id', $brand->id)->get()->first();
                $c = Category::find($c->category_id);
                $searchBrands = CategoryFunctions::GetBrandsInCategory($c->id);

                if( !$searchCategories ) // if no category found in search
                    $searchCategories = CategoryFunctions::GetSubCategoriesByName($c->name);
            }
        }
        else
            $searchBrands = SearchFunctions::GetBrandsInSearch(clone $qbuilder);
        
        return [ $qbuilder , $searchCategories , $searchBrands ];
    }

    /**
     * Process the searched text
     *
     * @param qbuilder  query builder object
     * @param category  category name
     * @param q  searched text
     * @param queries  suggested search queries
     * 
     * @return Array
     */ 
    private function filterResults($qbuilder, $urlQueries, $fromPrice, $toPrice)
    {
        // just show available results
        if( isset( $urlQueries['available'] ) )
            $qbuilder = $qbuilder->where('price_start', '!=', null);


        // filter by price range 
        if(  isset( $urlQueries['fromPrice'] ) || 
             isset( $urlQueries['toPrice'] ) ) {
            $qbuilder = $qbuilder->where('price_start', '>=', $fromPrice)
                                 ->where('price_start', '<=', $toPrice);
        }
        
        return $qbuilder;
    }

    /**
     * Process the searched text
     *
     * @param qbuilder  query builder object
     * @param category  category name
     * @param q  searched text
     * @param queries  suggested search queries
     * 
     * @return Array
     */ 
    private function sortResults($qbuilder, $sortBy)
    {
        switch($sortBy) {

            case 'priceMin':
            case 'priceMax':
                    $order = 'asc';
                    if($sortBy == 'priceMax')
                        $order = 'desc';

                    $qbuilder = $qbuilder->orderBy('price_start', $order)->where('price_start', '!=', null);
                break;

            case 'dateRecent':
                $qbuilder = $qbuilder->orderBy('id', 'desc');
                break;

            case 'mostFavorite':
                $qbuilder = $qbuilder->orderBy('favorites_count', 'desc');
                break;
        }
        
        return $qbuilder;
    }

    private function processResults($searchResults) 
    {
        $i = 0;
        foreach($searchResults as $p) { // loop through products
            if( $p->price_start == null ) { // if product not available in any shop
                $searchResults[$i]["price_start"] = 0;
                $searchResults[$i]["is_available"] = false;
            }
            else
                $searchResults[$i]["is_available"] = true;

            if( $p->shops_count == null ) { // if product is not available in any shop
                $shops = Offer::where('product_id', $p->id)->get();
                $searchResults[$i]["shops_count"] = count($shops); // get shops count
            }

            if($p->shops_count == 1) { // if product available in single shop
                $shopId = Offer::where('product_id', $p->id)->get()->first()->shop_id;
                $searchResults[$i]["shop_name"] = Shop::find($shopId)->title; // set shop name for product
            }
            else
                $searchResults[$i]["shop_name"] = "(Multiple)";

            $i++;
        }

        return $searchResults;
    }

}