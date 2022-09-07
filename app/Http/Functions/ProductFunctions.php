<?php

namespace App\Http\Functions;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Http\Functions\CategoryFunctions;

class ProductFunctions {
    
    /**
     *  Get product min and max prices
     *
     * @param pid product id
     * 
     * @return Array
     */ 
    public static function GetPricesRange($pid)
    {
        $range = Offer::where('product_id', $pid)
        ->selectRaw('MIN(price) as min, MAX(price) as max')
        ->groupBy('product_id')->get()->first();

        return $range;
    }

    /**
     *  Join offers and shops table and get product related data
     *
     * @param pid product id
     * 
     * @return Array Shops Offers
     */ 
    public static  function GetShopsOffers($pid)
    {
        // shops details
        $shops = Shop::select('shops.id', 'shops.title', 'shops.province');

        // product offers
        $offers = Offer::where('product_id', $pid)->orderBy('is_available', 'desc')->orderBy('price', 'asc');
        $qMinMaxPrices = clone $offers;

        // join tables and get each offer shop data
        $offers = $offers->leftJoinSub($shops, 'shops', function ($join) {
            $join->on('offers.shop_id', 'shops.id');
        })->get();

        return $offers;
    }

    /**
     *  Get product brand and all categories to the top
     *
     * @param pid product id
     * @param bid brand id
     * 
     * @return Array of Object
     */ 
    public static function GetBrandAndCategories($pid, $bid)
    {
        $brand = Brand::find($bid);

        $categoryId = ProductCategory::where('product_id', $pid)->orderBy('id', 'desc')->get()->first()->category_id;
        $category = Category::find($categoryId);

        $categories = CategoryFunctions::GetCategoryPath($category);
        
        return [ $brand , $categories ];
    }

}