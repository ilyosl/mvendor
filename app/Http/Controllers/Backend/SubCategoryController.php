<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use App\Models\SubCategoryModel;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function AllSubCategory(){
        $subCategories = SubCategoryModel::query()->latest()->get();

        return view('backend.subcategory.subcategory_all',compact('subCategories'));
    }
    public function AddSubCategory(){
        $categories = CategoryModel::query()->orderBy('category_name','ASC')->get();
        return view('backend.subcategory.subcategory_add',compact('categories'));
    }
    public function StoreSubCategory (Request $request){

        SubCategoryModel::query()->insert([
            'subcategory_name'=>$request->subcategory_name,
            'subcategory_slug'=> strtolower(str_replace(' ','-',$request->subcategory_name)),
            'category_id'=>$request->category_id,
        ]);

        $notification = [
            'message'=> 'SubCategory Inserted successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('all.subcategory')->with($notification);
    }
    public function EditSubCategory($id){
        $subcategory = SubCategoryModel::findOrFail($id);
        $categories = CategoryModel::query()->orderBy('category_name','ASC')->get();
        return view('backend.subcategory.subcategory_edit', compact('categories','subcategory'));
    }
    public function UpdateSubCategory(Request $request){
        $updateSubCategory = SubCategoryModel::findOrFail($request->id);
        if($updateSubCategory){
            $updateSubCategory->subcategory_name = $request->subcategory_name;
            $updateSubCategory->category_id = $request->category_id;
            $updateSubCategory->subcategory_slug = strtolower(str_replace(' ','-',$request->subcategory_name));
            $updateSubCategory->save();

            $notification = [
                'message'=> 'Sub Category Updated successfully',
                'alert-type'=>'success'
            ];

            return redirect()->route('all.subcategory')->with($notification);
        }
    }
    public function DeleteSubCategory($id){
        SubCategoryModel::findOrFail($id)->delete();
        $notification = [
            'message'=> 'Sub Category Deleted successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('all.subcategory')->with($notification);
    }
}
