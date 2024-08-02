<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'address', 'image'];

   

    protected $casts = [
        'emails' => 'array', // Cast the emails field as an array
    ];
}
