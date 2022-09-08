<?php

namespace App\Http\Functions;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
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
        ->groupBy('product_id')->where('is_available', true)->get()->first();

        return $range;
    }

    /**
     *  Get other products in same model as current product
     *
     * @param mid product model id
     * @param trait product model trait
     * 
     * @return Array of Products
     */ 
    public static function GetOtherModels($mid, $trait)
    {
        if($mid == null) return [];

        $products = Product::where('model_id', $mid); // find products with same model
        
        // offers table sub sql
        $offers = Offer::selectRaw("product_id, MIN(price) as price_start, COUNT(shop_id) as shops_count")
                       ->where('is_available', true)->groupBy('product_id');
            
        // join with offers sub sql to get each available product least price
        $products = $products->leftJoinSub($offers, 'product_prices', function ($join) {
            $join->on('products.id', 'product_prices.product_id');
        })
        ->get(['hash_id', 'title', 'model_trait', 'price_start']);

        $i = 0;
        foreach($products as $p) { 
            // fix null price and add is_available
            if($p->price_start == null) {
                $products[$i]['price_start'] = 0;
                $products[$i]['is_available'] = false;
            }
            else
                $products[$i]['is_available'] = true;

            
            if($p->model_trait == $trait)
                $products[$i]['current_product'] = true;
            else
                $products[$i]['current_product'] = false;

            $i++;
        }
        
        return $products;
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