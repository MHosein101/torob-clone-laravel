<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\CategoryBrand;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Functions\SearchFunctions;
use App\Http\Functions\CategoryFunctions;

class SearchController extends Controller
{

    /**
     * Suggest some search queries and categories by using a text that user typed
     *
     * @param text  text that user typed
     * 
     * @return Response Json
     */ 
    public function suggestion(Request $request, $text)
    {
        $queries = SearchFunctions::SuggestSearchQuery($text);
        $categories = SearchFunctions::SuggestCategoriesInSearch($queries);

        return response()
        ->json([
            'message' => 'Ok' ,
            'data' => [
                'suggested_queries' => $queries ,
                'suggested_categories' => $categories
            ]
        ], 200);
    }

    /**
     * Default search parameters if not included in search request
     * @var Array
     */
    private $defaultQueryParams = [
        'q' => null ,
        'category' => null ,
        'brand' => null ,
        'sort' => 'dateRecent' , // dateRecent , priceMin , priceMax , mostFavorite
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
     * @return Response Json
     */ 
    public function search(Request $request)
    {
        // sleep(random_int(1,3)); // FOR DEBUG

        // get url queries and fill parameters with default config if not set
        $params = SearchFunctions::ConfigQueryParams($request->query(), $this->defaultQueryParams);

        if( $params["q"] == null && $params["category"] == null && $params["brand"] == null ) // check url params
            return response()->json([ 'message' => 'Define at least one of these parameters : q (search query) , category , brand' ], 400);

        $searchQueryBuilder = null;
        $take = $params["perPage"]; // pagination limit
        $skip = ( $params["page"] - 1 ) * $params["perPage"]; // pagination offset

        $suggestedQueries = [];
        $searchCategories = [];
        $searchBrands = [];
        
        $searchQueryBuilder =  SearchFunctions::joinTables();

        if($params["q"] != null) { // if search query included  
            // suggest similar queries
            $suggestedQueries = SearchFunctions::SuggestSearchQuery($params["q"], $take, $skip);
            // filter products by search texts
            $searchQueryBuilder = SearchFunctions::LimitProductsWithQueries($suggestedQueries, clone $searchQueryBuilder);
        }

        // check category and filter
        $data = $this->processCategory( $searchQueryBuilder , $params["category"] , $params["q"], $suggestedQueries );
        
        $searchQueryBuilder = $data[0];
        $searchCategories = $data[1];
        $searchBrands = $data[2];

        // check brand and filter
        $data = $this->processBrand( $searchQueryBuilder , $params["brand"] , $searchBrands );
        
        $searchQueryBuilder = $data[0];
        $searchBrands = $data[1];

        // filter by price and availability
        $searchQueryBuilder = $this->filterResults( $searchQueryBuilder , $request->query() , $params["fromPrice"] , $params["toPrice"] );

        // clone current sql query to get min and max product prices
        $productsPriceMin = clone $searchQueryBuilder;
        $productsPriceMax = clone $searchQueryBuilder;

        $searchQueryBuilder = $this->sortResults( $searchQueryBuilder , $params["sort"] );

        // make pagination from results
        $searchQueryBuilder = $searchQueryBuilder->skip($skip)->take($take);

        $searchResults = $searchQueryBuilder
        ->get(['id', 'hash_id', 'products.title','image_url', 'price_start', 'shops_count']); // get selected values
        // ->get();
        // dd($searchResults);

        $searchResults =  SearchFunctions::processResults( $searchResults );
        
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

        return response()
        ->json([
            'message' => 'Ok' ,
            'data' => [
                'pproducts_count' => count($searchResults) ,
                'price_range' => [ 
                    'min' => $priceRangeMin , 
                    'max' => $priceRangeMax 
                ] ,
                'brands' => $searchBrands ,
                'categories' => $searchCategories ,
                'products' => $searchResults
            ]
        ], 200);
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
        $categoryType = '';

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
        else if($q) {
            $searchCategories = SearchFunctions::SuggestCategoriesInSearch($queries, clone $qbuilder);
        }

        return [ $qbuilder , $searchCategories , $searchBrands ];
    }

    /**
     * Process the searched text
     *
     * @param qbuilder  query builder object
     * @param brand  brand name
     * @param searchCategories  array of categories related to search
     * @param searchBrands  array of brands related to search category
     * 
     * @return Array
     */ 
    private function processBrand($qbuilder, $brand, $searchBrands)
    {
        $brand = SearchFunctions::BrandExists($brand);
        $searchBrands = [];

        if( $brand ) {
            $qbuilder = $qbuilder->where('brand_id', $brand->id); // filter by brand

            if( !$searchBrands ) { // if no brand found in search

                $c = CategoryBrand::where('brand_id', $brand->id)->get()->first(); // find brand category
                $c = Category::find($c->category_id);
                $searchBrands = CategoryFunctions::GetBrandsInCategory($c->id); // get brands under category
            }
        }
        else // if brand name not included in search then find them by matched product brand id
            $searchBrands = SearchFunctions::GetBrandsInSearch(clone $qbuilder);
        
        return [ $qbuilder , $searchBrands ];
    }

    /**
     * Filter search results
     *
     * @param qbuilder  query builder object
     * @param urlQueries  url query string array
     * @param fromPrice  the least price
     * @param toPrice  the most price
     * 
     * @return Product
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
     * Sort search results
     *
     * @param qbuilder  query builder object
     * @param sortBy  sort type
     * 
     * @return Product
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
                // no idea how
                break;
        }
        
        return $qbuilder;
    }

}