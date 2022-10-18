<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCollage extends Model
{
    use HasFactory;

    protected $table = 'user_collages';
    protected $guarded = [];

    public function collage()
    {
        return $this->belongsTo(Collage::class, 'collage_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
