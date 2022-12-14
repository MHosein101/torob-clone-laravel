<?php

namespace App\Http\Functions;

use App\Models\Shop;
use App\Models\Brand;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Category;
use App\Models\ShopOrder;
use App\Models\ProductCategory;
use App\Models\ShopOrderTracking;
use App\Models\ProductPricesChart;
use App\Http\Functions\CategoryFunctions;

class ProductFunctions {
    
    /**
     *  Get product min and max prices in available shops
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

        if($range == null)
            return ['min' => 0, 'max' => 0];
            
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
        $search = ['گوشی', 'موبایل', 'Mobile', 'Phone', 'mobile'];

        foreach($search as $s) {
            if( strpos($ptitle, $s) !== false )
                return true;
        }

        return false;
    }

    /**
     *  Get other products in same model as current product
     *
     * @param model product model name
     * @param trait product model trait
     * 
     * @return Array of Products
     */ 
    public static function GetOtherModels($model, $trait)
    {
        if($model == null || $model == '') return [];

        $products = Product::where('model_name', $model); // find products with same model
        
        // offers table sub sql
        $offers = Offer::selectRaw("product_id, MIN(price) as price_start, COUNT(shop_id) as shops_count")
                       ->where('is_available', true)->groupBy('product_id');
            
        // join with offers sub sql to get each available product least price
        $products = $products->leftJoinSub($offers, 'product_prices', function ($join) {
            $join->on('products.id', 'product_prices.product_id');
        })
        ->get(['hash_id', 'title', 'model_trait', 'price_start']);

        if( count($products) == 1 ) return [];

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
     *  Join offers and shops table and get product related sales
     *
     * @param pid product id
     * @param firstRegisteredMobile to get cheapest registered mobile  shop link
     * @param provinces array of providence names to filter
     * @param cities array of city names to filter
     * @param ignores list of filtered results id to ignore in next request for others
     * 
     * @return Array Shops Offers
     */ 
    public static  function GetShopsOffers($pid, $firstRegisteredMobile, $provinces = null, $cities = null, $ignores = null)
    {
        // shops details
        $shops = Shop::selectRaw('shops.id as shop_id, title as shop_title, province, city, rate as shop_rate, cooperation_activity, delivery_attention ,delivery_methods, advantage_inplace_pay, advantage_instant_delivery, advantage_free_delivery');

        // product offers
        $offers = Offer::where('product_id', $pid)
        ->orderBy('is_available', 'desc')
        ->orderBy('price', 'asc');

        if($firstRegisteredMobile)
            $offers = $offers->where('is_mobile_registered', true);

        // join tables and get each offer shop data
        $offers = $offers->leftJoinSub($shops, 'shops', function ($join) {
            $join->on('offers.shop_id', 'shops.shop_id');
        });
        
        $offers->where(function($query) use ($provinces, $cities, $ignores) {
            
            if($provinces != null)
                $query->whereIn('province', $provinces);

            if($cities != null)
                $query->orWhereIn('city', $cities);

            if($ignores != null)
                $query->whereNotIn('offers.shop_id', $ignores);
       });
        
        $offers = $offers->get();

        $offers = ProductFunctions::LoopShopsOffersData($offers);

        return $offers;
    }

    /**
     *  reshape and clean up the data and add some new data
     *
     * @param offers shops offers
     * 
     * @return Array
     */ 
    public static  function LoopShopsOffersData($offers)
    {
        $data = [];

        foreach($offers as $f) {
            // get each shop user order tracking count and all orders count in last 3 month
            $trackings = count( ShopOrderTracking::where('shop_id', $f->id)->get('id') );
            $orders = count( ShopOrder::where('shop_id', $f->id)->get('id') );

            $pows = [500, 1000, 250];
            $by = $pows[random_int(0, 2)];
            $ordersMin = floor($orders / 100) * $by; // for test - multiply the value by random numbers
            $ordersMax = ceil($orders / 100) * $by; // for test - multiply the value by random numbers
            
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
                'id' => $f->shop_id ,
                'title' => $f->shop_title ,
                'province' => $f->province ,
                'city' => $f->city ,
                'rate' => $f->shop_rate ,
                'activity_time' => $f->cooperation_activity ,
                'delivery_attention' => $f->delivery_attention ,
                'delivery_methods' => explode('|', $f->delivery_methods) ,
                'stats' => [
                    'trackings' => $trackings ,
                    'orders' => [ 'min' => $ordersMin , 'max' => $ordersMax ]
                ] ,
                'badges' => [] ,
                'advantage' => [] 
            ];
            if( $f->advantage_inplace_pay != '' ) {
                $shop['advantage'][] = [
                    'type' => 'inplace_pay' ,
                    'title' => $f->advantage_inplace_pay
                ];
                $shop['badges'][] = [
                    'type' => 'inplace_pay' ,
                    'title' => 'پرداخت در محل'
                ];
            }
            if( $f->advantage_instant_delivery != '' ) {
                $shop['advantage'][] = [
                    'type' => 'instant_delivery' ,
                    'title' => $f->advantage_instant_delivery
                ];
                $shop['badges'][] = [
                    'type' => 'instant_delivery' ,
                    'title' => 'تحویل فوری'
                ];
            }
            if( $f->advantage_free_delivery != '' ) {
                $shop['advantage'][] = [
                    'type' => 'free_delivery' ,
                    'title' => $f->advantage_free_delivery
                ];
                $shop['badges'][] = [
                    'type' => 'free_delivery' ,
                    'title' => 'ارسال رایگان'
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
        $path = $categories;

        $lastCat = $categories[ count($categories) - 1 ];
        $brandName = "{$brand->name} ({$brand->name_english})";

        $path[] = [ 
            'type' => 'brand' , 
            'title' => $brandName , 
            'brand' => $brand->name , 
            'category' => $lastCat['title'] 
        ];

        return $path;
    }

}