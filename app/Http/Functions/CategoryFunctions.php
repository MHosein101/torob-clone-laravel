<?php

namespace App\Http\Functions;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;

class CategoryFunctions {

    public static function GetSubCategories($val) {
        $categories = [];

        $subIDs = Category::where('parent_id', '=', $val)->get('id');
        foreach($subIDs as $sid) {
            $c = Category::where('id', '=', $sid->id)->first();
            $categories[] = $c->name;
        }

        return $categories;
    }

    public static function GetSubCategoriesByID($categoryId) {
        return CategoryFunctions::GetSubCategoriesByName( Category::find($categoryId)->name , true );
    }

    public static function GetSubCategoriesByName($categoryName, $showAllLevels = false) {
        $category = Category::where('name', '=', $categoryName)->get();
        if( count($category) != 1 ) return;
    
        $category = $category[0];
        $subCategories = [];
        
        switch($category->level) {
            case 1:
                $category = CategoryFunctions::GetSubCategories($category->id);
                break;
            case 2:
                $category = Category::find($category->parent_id);
                $subCategories = CategoryFunctions::GetSubCategories($category->id);
                
                $category = [
                    'name' => $category->name ,
                    'sub_categories' => $subCategories
                ];
                break;
            case 3:
                $category = Category::find($category->parent_id);
                $second = clone $category;
                $category = Category::find($second->parent_id);
                $subCategories = CategoryFunctions::GetSubCategories($second->id);

                $category = [
                    'name' => $category->name ,
                    'sub_categories' => [
                        'name' => $second->name ,
                        'sub_categories' => $subCategories
                    ]
                ];
                break;
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