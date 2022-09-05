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
        $categoryName = $request->route('name');
        $category = CategoryFunctions::Exists($categoryName);

        if( !$category ) 
            return response()->json([
                'message' => 'Category name is NOT valid.'
            ], 400);
        
        // $request->merge([ 'category' => $category ]);
        $request->merge(compact('category'));

        return $next($request);
    }
}