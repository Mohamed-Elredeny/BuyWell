<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(OrderProducts::class, 'order_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function history()
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }
    protected function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }



}
