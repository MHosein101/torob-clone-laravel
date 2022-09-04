<?php

namespace App\Http\Functions;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryBrand;

class CategoryFunctions {

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

    public static function GetSubCategories($val) {
        $categories = [];

        $subIDs = Category::where('parent_id', '=', $val)->get('id');
        foreach($subIDs as $sid) {
            $c = Category::where('id', '=', $sid->id)->first();
            $categories[] = $c;
        }

        return $categories;
    }

    public static function GetSubCategoriesByName($category) {
        $subCategory = null;
        $subCategorySubCategories = null;
        
        switch($category->level) {
            case 1:
                return [
                    'id' => $category->id ,
                    'name' => $category->name ,
                    'sub_categories' => CategoryFunctions::GetSubCategories($category->id)
                ];
                break;
            case 2:
                $subCategory = clone $category;
                $category = Category::find($category->parent_id);
                $subCategorySubCategories = CategoryFunctions::GetSubCategories($subCategory->id);
                break;
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
                $subCategory = Category::find($category->parent_id);
                $category = Category::find($subCategory->parent_id);
                $subCategorySubCategories = CategoryFunctions::GetSubCategories($subCategory->id);
                break;
        }
        
        return [
            'id' => $category->id ,
            'name' => $category->name ,
            'sub_categories' => [
                'id' => $subCategory->id ,
                'name' => $subCategory->name ,
                'sub_categories' => $subCategorySubCategories
            ]
        ];
    }

    public static function GetBrandsInCategory($categoryID) {
        $brandsIDs = CategoryBrand::where('category_id', '=', $categoryID)->get('brand_id');

        $brands = [];
        foreach($brandsIDs as $bid)
            $brands[] = Brand::find($bid)->first();

        return $brands;
    }

}