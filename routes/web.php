<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});
Route::middleware(['auth','role:user'])->group(function(){
    Route::get('/dashboard', [\App\Http\Controllers\UserController::class, 'UserDashboard'])->name('dashboard');
    Route::post('/user/profile/store',[\App\Http\Controllers\UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/logout', [\App\Http\Controllers\UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/update/password', [\App\Http\Controllers\UserController::class, 'UserUpdatePassword'])->name('user.update.password');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'AdminDashBoard'])->name('admin.dashboard');
    Route::get('/admin/logout', [\App\Http\Controllers\AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [\App\Http\Controllers\AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile', [\App\Http\Controllers\AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::post('/admin/update/password', [\App\Http\Controllers\AdminController::class, 'AdminUpdatePassword'])->name('update.password');
    Route::get('/admin/change/password', [\App\Http\Controllers\AdminController::class, 'AdminChangePassword'])->name('admin.change.password');

    // Brand Controller
    Route::controller(\App\Http\Controllers\Backend\BrandController::class)->group(function (){
        Route::get('/all/brand','AllBrand')->name('all.brand');
        Route::get('/add/brand','AddBrand')->name('add.brand');
        Route::post('/store/brand','StoreBrand')->name('store.brand');
        Route::post('/update/brand','UpdateBrand')->name('update.brand');
        Route::get('/edit/brand/{id}','EditBrand')->name('edit.brand');
        Route::get('/delete/brand/{id}','DeleteBrand')->name('delete.brand');
    });
    // Category Controller
    Route::controller(\App\Http\Controllers\Backend\CategoryController::class)->group(function (){
        Route::get('/all/category','AllCategory')->name('all.category');
        Route::get('/add/category','AddCategory')->name('add.category');
        Route::post('/store/category','StoreCategory')->name('store.category');
        Route::post('/update/category','UpdateCategory')->name('update.category');
        Route::get('/edit/category/{id}','EditCategory')->name('edit.category');
        Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');
    });
    // SubCategory Controller
    Route::controller(\App\Http\Controllers\Backend\SubCategoryController::class)->group(function (){
        Route::get('/all/subcategory','AllSubCategory')->name('all.subcategory');
        Route::get('/add/subcategory','AddSubCategory')->name('add.subcategory');
        Route::post('/store/subcategory','StoreSubCategory')->name('store.subcategory');
        Route::post('/update/subcategory','UpdateSubCategory')->name('update.subcategory');
        Route::get('/edit/subcategory/{id}','EditSubCategory')->name('edit.subcategory');
        Route::get('/delete/subcategory/{id}','DeleteSubCategory')->name('delete.subcategory');
    });
     // Vendor Manage routes
    Route::controller(\App\Http\Controllers\AdminController::class)->group(function (){
        Route::get('/inactive/vendor','InactiveVendor')->name('inactive.vendor');
        Route::get('/active/vendor','ActiveVendor')->name('active.vendor');
        Route::post('/vendor/approve','VendorApprove')->name('vendor.approve');
        Route::get('/vendor/details/{id}','VendorDetails')->name('vendor.details');
    });

    // Products Controller
    Route::controller(\App\Http\Controllers\Backend\ProductController::class)->group(function (){
        Route::get('/all/product','AllProduct')->name('all.product');
        Route::get('/add/product','AddProduct')->name('add.product');
    });




});
Route::middleware(['auth','role:vendor'])->group(function(){
    Route::get('/vendor/dashboard', [\App\Http\Controllers\VendorController::class, 'VendorDashBoard'])->name('vendor.dashboard');
    Route::get('/vendor/logout', [\App\Http\Controllers\VendorController::class, 'VendorDestroy'])->name('vendor.logout');
    Route::get('/vendor/profile', [\App\Http\Controllers\VendorController::class, 'VendorProfile'])->name('vendor.profile');
    Route::post('/vendor/profile', [\App\Http\Controllers\VendorController::class, 'VendorProfileStore'])->name('vendor.profile.store');
    Route::post('/vendor/update/password', [\App\Http\Controllers\VendorController::class, 'VendorUpdatePassword'])->name('vendor.update.password');
    Route::get('/vendor/change/password', [\App\Http\Controllers\VendorController::class, 'VendorChangePassword'])->name('vendor.change.password');
});

Route::get('/admin/login', [\App\Http\Controllers\AdminController::class, 'AdminLogin']);
Route::get('/vendor/login', [\App\Http\Controllers\VendorController::class, 'VendorLogin'])->name('vendor.login');
Route::get('/become/vendor', [\App\Http\Controllers\VendorController::class, 'BecomeVendor'])->name('become.vendor');
Route::post('/vendor/register', [\App\Http\Controllers\VendorController::class, 'VendorRegister'])->name('vendor.register');



