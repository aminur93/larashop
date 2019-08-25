<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function OrderItems()
    {
        return $this->hasMany(OrderItems::class);
    }
    
    public function Products()
    {
        return $this->belongsToMany(Product::class,'order_items');
    }
}
