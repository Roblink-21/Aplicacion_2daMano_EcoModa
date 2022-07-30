<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return "slug";
    }

    // Relación de uno a muchos
    // Una categoria puede realizar muchos post de productos
    public function products(){
        return $this ->hasMany(Product::class);
    }

}
