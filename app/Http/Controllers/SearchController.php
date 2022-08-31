<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    
    public function search(
        Request $request, 
        $term = null, 
        $sort = 'newest', 
        $available = 'no', 
        $priceMin = 0, 
        $priceMax = 1000000000)
    {
        // dd($term, $sort, $available, $priceMin, $priceMax);


        
    }
}
