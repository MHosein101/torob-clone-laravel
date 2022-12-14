<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckProduct
{
    public function handle(Request $request, Closure $next)
    {
        $hid = $request->route('hash'); // get route parameter
        $product = Product::where('hash_id', $hid)->get()->first(); // check if exists

        if($product == null)
            return response()->json([ 'message' => 'Product not found.' ], 404);
        
        $request->merge(compact('product')); // send to controller
        return $next($request);
    }
}
