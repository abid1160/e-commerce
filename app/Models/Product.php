<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_name', 
        'category', 
        'price', 
        'quantity',
        'category_id',  
        'subcategory_id',
        'description',
        'color',
        'size',
        
    ];
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function masterImage()
    {
        return $this->hasOne(Image::class)->where('is_master', true);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
public function carts()
{
    return $this->hasMany(Cart::class);
}
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}
public function discount()
{
    return $this->hasOne(Discount::class, 'product_id');
}


}
