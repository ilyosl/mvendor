<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\BrandModel::class, 'brand_id');
            $table->foreignIdFor(\App\Models\CategoryModel::class, 'category_id');
            $table->foreignIdFor(\App\Models\SubCategoryModel::class, 'subcategory_id');
            $table->string('product_name');
            $table->string('product_slug');
            $table->string('product_code');
            $table->integer('product_qty');
            $table->integer('selling_price');
            $table->integer('discount_price')->default(0)->nullable();
            $table->string('product_tags')->nullable();
            $table->text('short_desc');
            $table->longText('long_desc');
            $table->string('product_thumbnail');
            $table->foreignIdFor(\App\Models\User::class, 'vendor_id');
            $table->smallInteger('hot_deals')->default(0)->nullable();
            $table->smallInteger('featured')->default(0)->nullable();
            $table->smallInteger('special_offer')->default(0)->nullable();
            $table->smallInteger('special_deals')->default(0)->nullable();
            $table->smallInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
