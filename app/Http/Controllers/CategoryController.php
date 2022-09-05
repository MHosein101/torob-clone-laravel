<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;
use Illuminate\Http\Request;
use App\Http\Functions\CategoryFunctions;

class CategoryController extends Controller
{
    /**
     * Get a tree of all categories and their children
     * 
     * @return Json (Array of Category)
     */ 
    public function getAll(Request $request)
    {
        $date = [];
        // get all first level categories
        $topCategoriesIDs = Category::where('level', 1)->get();

        // get their subcategories tree
        foreach($topCategoriesIDs as $topc)
            $data[] = CategoryFunctions::GetCategoriesTree($topc->id);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $data
        ], 200);
    }

    /**
     * Get children of a category and its parents to the top if it has
     *
     * @param name  name of category (checked in middleware)
     * @param category  category object (returned by middleware)
     * 
     * @return Json (Array of Category)
     */ 
    public function getSubCategories(Request $request)
    {
        $category = $request->category; // returned by middleware
        $subCategories = CategoryFunctions::GetSubCategoriesByName($category->name);
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => $subCategories
        ], 200);
    }

    /**
     * Get brands that connected to a category
     *
     * @param name  name of category (checked in middleware)
     * @param category  category object (returned by middleware)
     * 
     * @return Json (Array of Brand)
     */ 
    public function getBrands(Request $request)
    {
        $category = $request->category; // returned by middleware
        $brands = CategoryFunctions::GetBrandsInCategory($category->id);

        return response()->json([
            'message' => 'Ok' ,
            'data' => $brands
        ], 200);
    }

    /**
     * Get a category's parents to the top
     *
     * @param name  name of category (checked in middleware)
     * @param category  category object (returned by middleware)
     * 
     * @return Json (Array of Category)
     */ 
    public function getPath(Request $request)
    {
        $category = $request->category; // returned by middleware
        $path = [];

        $path[] = $category;
        if($category->level != 1 ) { // if its not the first level parent
            while( $category->level != 1 ) { // until its not the first level parent do these
                $category = Category::where('id', $category->parent_id)->get()->first(); // get parent category
                $path[] = $category; // add to path
            }
        }
        
        return response()->json([
            'message' => 'Ok' ,
            'data' => array_reverse($path)
        ], 200);

    }

}
