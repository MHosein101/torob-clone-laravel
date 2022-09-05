<?php

namespace App\Http\Functions;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;

class CategoryFunctions {

    public static function Exists($categoryName) {
        $category = Category::where('name', $categoryName)->get();

        if( count($category) == 0 ) 
            return false;

        return $category[0];
    }

    public static function GetCategoriesTree($id) {
        $category = Category::find($id);
        $subCategoriesIDs = Category::where('parent_id', $id)->get();
        $brandsIDs = CategoryBrand::where('category_id', $category->id)->get();

        if( count($brandsIDs) > 0 ) {
            $brands = [];

            foreach($brandsIDs as $b)
                $brands[] = Brand::find($b->id);

            $category["brands"] = $brands;
        }

        if(  count($subCategoriesIDs) > 0  ) {
            $subCategories = [];

            foreach($subCategoriesIDs as $subc)
                $subCategories[] = CategoryFunctions::GetCategoriesTree($subc->id);

            $category["status"] = false;
            $category["is_sub_category"] = true;
            $category["sub_categories"] = $subCategories;
        }

        return $category;
    }

    public static function GetSubCategories($pid) {
        $categories = [];

        $subIDs = Category::where('parent_id', '=', $pid)->get('id');
        foreach($subIDs as $sid)
            $categories[] = Category::find($sid->id);

        return $categories;
    }

    public static function GetSubCategoriesByName($categoryName) {
        $category = CategoryFunctions::Exists($categoryName);
        if( !$category ) return;

        $subCategories = CategoryFunctions::GetSubCategories($category->id);

        if( count($subCategories) == 0 )
            $category = Category::where('id', $category->parent_id)->get()->first();

        // $brands = CategoryFunctions::GetBrandsInCategory($category->id);
        // if( count($brands) > 0 )
        //     $category['brands'] = $brands;
            
        $subCategories = CategoryFunctions::GetSubCategories($category->id);
        $category['sub_categories'] = $subCategories;

        while( $category->level != 1 ) {
            $parentCategory = Category::where('id', $category->parent_id)->get()->first();
            $parentCategory['sub_categories'] = $category;
            $category = $parentCategory;
        }

        return $category;
    }

    public static function GetBrandsInCategory($categoryID) {
        $brandsIDs = CategoryBrand::where('category_id', '=', $categoryID)->get('brand_id');

        $brands = [];
        foreach($brandsIDs as $bid)
            $brands[] = Brand::find($bid);

        return $brands;
    }

}