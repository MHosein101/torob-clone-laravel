<?php

namespace App\Http\Functions;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\ProductPricesChart;
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
     *  Check if product is mobile
     *
     * @param ptitle product title
     * 
     * @return Array
     */ 
    public static function IsMobile($ptitle)
    {
        $search = ['گوشی', 'موبایل'];

        foreach($search as $s) {
            if( strpos($ptitle, $s) !== false )
                return true;
        }

        return false;
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
    public static  function GetShopsOffers($pid, $limitByRegistery, $provinces = null, $cities = null)
    {
        // shops details
        $shops = Shop::selectRaw('id, title as shop_title, province, city, rate as shop_rate, cooperation_activity, delivery_attention ,delivery_methods, advantage_inplace_pay, advantage_instant_delivery, advantage_free_delivery');

        // product offers
        $offers = Offer::where('product_id', $pid)
        ->orderBy('is_available', 'desc')
        ->orderBy('price', 'asc');

        if($limitByRegistery)
            $offers = $offers->where('is_mobile_registered', true);

        $qMinMaxPrices = clone $offers;

        // join tables and get each offer shop data
        $offers = $offers->leftJoinSub($shops, 'shops', function ($join) {
            $join->on('offers.shop_id', 'shops.id');
        })->get();


        $offers = ProductFunctions::ReOrderShopsOffersData($offers);

        return $offers;
    }

    /**
     *  re order and clean up the data
     *
     * @param data shops offers
     * 
     * @return Array Shops Offers
     */ 
    public static  function ReOrderShopsOffersData($offers)
    {
        $data = [];

        foreach($offers as $f) {

            $offer = [
                'title' => $f->title ,
                'price' => $f->price ,
                'is_available' => $f->is_available ,
                'is_mobile_registered' => $f->is_mobile_registered ,
                'guarantee' => $f->guarantee ,
                'redirect_url' => $f->redirect_url ,
                'last_update' => $f->last_update ,
            ];

            $shop = [
                'title' => $f->shop_title ,
                'province' => $f->province ,
                'city' => $f->city ,
                'rate' => $f->shop_rate ,
                'activity_time' => $f->cooperation_activity ,
                'delivery_attention' => $f->delivery_attention ,
                'delivery_methods' => explode('|', $f->delivery_methods) ,
                'advantage' => [] 
            ];

            if( $f->advantage_inplace_pay != '' ) {
                $shop['advantage'][] = [
                    'type' => 'inplace_pay' ,
                    'title' => $f->advantage_inplace_pay
                ];
            }
            if( $f->advantage_instant_delivery != '' ) {
                $shop['advantage'][] = [
                    'type' => 'instant_delivery' ,
                    'title' => $f->advantage_instant_delivery
                ];
            }
            if( $f->advantage_free_delivery != '' ) {
                $shop['advantage'][] = [
                    'type' => 'free_delivery' ,
                    'title' => $f->advantage_free_delivery
                ];
            }

            $data[] = [
                'offer' => $offer ,
                'shop' => $shop
            ];

        }

        return $data;
    }

    /**
     *  Get product prices changes data for chart
     *
     * @param pid product id
     * 
     * @return ProductPricesChart
     */ 
    public static function GetChartPricesData($pid)
    {
        return ProductPricesChart::where('product_id', $pid)->get(['date', 'price', 'average_price']);
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

    /**
     *  Get product brand and all categories to the top
     *
     * @param brand product brand
     * @param categories product categories to top
     * 
     * @return Array of String
     */ 
    public static function MakeProductPath($brand, $categories)
    {
        $path = [];
        $brandName = "{$brand->name} ({$brand->name_english})";

        foreach($categories as $c)
            $path[] = $c->name;

        $path[] = $brandName;

        return $path;
    }

}