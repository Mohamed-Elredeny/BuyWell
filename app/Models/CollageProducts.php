<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollageProducts extends Model
{
    use HasFactory;

    protected $table = 'collages_products';
    protected $guarded = [];

    public function collage()
    {
        return $this->belongsTo(Collage::class, 'collage_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
