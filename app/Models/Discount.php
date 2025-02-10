<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [ 'type','value',  'start_date', 'end_date', 'is_active','user_id','product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'discount_user');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
