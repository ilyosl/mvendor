<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\SubCategoryModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function AllProduct(){
        $products = ProductModel::query()->latest()->get();

        return view('backend.product.product_all', compact('products'));
    }
    public function AddProduct(){
        return view('backend.product.product_add');
    }
}
