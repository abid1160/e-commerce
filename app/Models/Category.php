<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Table name (optional if it follows Laravel's pluralization rule)
    protected $table = 'categories';

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    // Define the relationship with Subcategory
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
    public function products()
{
    return $this->hasMany(Product::class);
}
}
