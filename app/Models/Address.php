<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'label', // e.g., "Home", "Work"
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        
    ];

    /**
     * Relationship: An address belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: An address can be used in multiple orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
