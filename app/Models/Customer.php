<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['code', 'name', 'phone', 'address', 'is_active', 'created_at', 'updated_at'];
}
