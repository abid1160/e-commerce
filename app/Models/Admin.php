<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    // You don't need to set the $guard property in the model.

    protected $fillable = ['name', 'email', 'password', 'phone_number','usertype'];
}
