<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function AllCategory(){
        $categories = CategoryModel::query()->latest()->get();
        return view('backend.category.category_all', compact('categories'));
    }
    public function AddCategory(){
        return view('backend.category.category_add');
    }
    public function StoreCategory(Request $request){
        $image = $request->file('category_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(120,120)->save('upload/category_images/'.$name_gen);

        CategoryModel::query()->insert([
            'category_name'=>$request->category_name,
            'category_slug'=> strtolower(str_replace(' ','-',$request->category_name)),
            'category_image'=>$name_gen,
        ]);

        $notification = [
            'message'=> 'Category Inserted successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('all.category')->with($notification);
    }
    public function EditCategory($id){
        $category = CategoryModel::findOrFail($id);
        return view('backend.category.category_edit', compact('category'));
    }
    public function UpdateCategory(Request $request){
        $updateCategory = CategoryModel::findOrFail($request->id);
        if($updateCategory){
            $image = $request->file('category_image');
            if($image) {
                @unlink(public_path('upload/category_images/' . $updateCategory->category_image));
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(120, 120)->save('upload/category_images/' . $name_gen);
                $updateCategory->category_image = $name_gen;
            }
            $updateCategory->category_name = $request->category_name;
            $updateCategory->category_slug = strtolower(str_replace(' ','-',$request->category_name));
            $updateCategory->save();

            $notification = [
                'message'=> 'Category Updated successfully',
                'alert-type'=>'success'
            ];

            return redirect()->route('all.category')->with($notification);
        }
    }
    public function DeleteCategory($id){
        $category = CategoryModel::findOrFail($id);
        @unlink(public_path('upload/category_images/' . $category->category_image));
        $category->delete();
        $notification = [
            'message'=> 'Category Deleted successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('all.category')->with($notification);
    }
}
