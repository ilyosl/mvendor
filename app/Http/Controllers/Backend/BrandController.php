<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BrandModel;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function AllBrand(){
        $brands = BrandModel::query()->latest()->get();

        return view('backend.brand.brand_all', compact('brands'));
    }
    public function AddBrand(){
        return view('backend.brand.brand_add');
    }
    public function StoreBrand(Request $request){
        $image = $request->file('brand_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(300,300)->save('upload/brand_images/'.$name_gen);

        BrandModel::query()->insert([
            'brand_name'=>$request->brand_name,
            'brand_slug'=> strtolower(str_replace(' ','-',$request->brand_name)),
            'brand_image'=>$name_gen,
        ]);

        $notification = [
            'message'=> 'Brand Inserted successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('all.brand')->with($notification);
    }
    public function EditBrand($id){
        $brand = BrandModel::findOrFail($id);
        return view('backend.brand.brand_edit', compact('brand'));
    }
    public function UpdateBrand(Request $request){
        $updateBrand = BrandModel::findOrFail($request->id);
        if($updateBrand){
            $image = $request->file('brand_image');
            if($image) {
                @unlink(public_path('upload/brand_images/' . $updateBrand->brand_image));
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(300, 300)->save('upload/brand_images/' . $name_gen);
                $updateBrand->brand_image = $name_gen;
            }
            $updateBrand->brand_name = $request->brand_name;
            $updateBrand->brand_slug = strtolower(str_replace(' ','-',$request->brand_name));
            $updateBrand->save();

            $notification = [
                'message'=> 'Brand Updated successfully',
                'alert-type'=>'success'
            ];

            return redirect()->route('all.brand')->with($notification);
        }
    }
    public function DeleteBrand($id){
        $brand = BrandModel::findOrFail($id);
        @unlink(public_path('upload/brand_images/' . $brand->brand_image));
        $brand->delete();
        $notification = [
            'message'=> 'Brand Deleted successfully',
            'alert-type'=>'success'
        ];

        return redirect()->route('all.brand')->with($notification);
    }
}
