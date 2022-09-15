<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Functions\CategoryFunctions;

class CheckCategoryName
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
        $cname = $request->route('name'); // get route parameter
        $category = CategoryFunctions::Exists($cname); // check if exists

        if( !$category ) 
            return response()->json([ 'message' => 'Category not found.' ], 404);
        
        // $request->merge([ 'category' => $category ]);
        $request->merge(compact('category')); // send to controller
        return $next($request);
    }
}
