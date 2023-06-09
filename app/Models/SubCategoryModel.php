<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'sub_category';

    protected $guarded = [];

    public function Category(){
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
}
