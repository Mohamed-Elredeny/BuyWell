<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collage extends Model
{
    use HasFactory;

    protected $table = 'collages';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(CollageProducts::class, 'collage_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
}
