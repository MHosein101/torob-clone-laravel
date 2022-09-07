<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckProductName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ptitle = $request->route('name'); // get route parameter
        $product = Product::where('title', $ptitle)->get()->first(); // check if exists

        if($product == null)
            return response()->json([
                'message' => 'Product not found.'
            ], 404);
        
        $request->merge(compact('product')); // send to controller
        return $next($request);
    }
}
