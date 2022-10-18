<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function brand(){
        return $this->belongsTo(Brand::class,'is_brand');
    }
    public function category(){
        return $this->belongsTo(Category::class,'model_id');
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class,'model_id');
    }

    public function ProductSpecifications(){
        return $this->belongsTo(SubCategory::class,'product_id');
    }
}
