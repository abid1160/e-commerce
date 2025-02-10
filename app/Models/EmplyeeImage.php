<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmplyeeImage extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'profile_path'];

    public function product()
    {
        return $this->belongsTo(Employee::class);
    }
}
