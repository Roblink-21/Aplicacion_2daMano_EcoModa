<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasImage;

    protected $fillable = ['name', 'slug', 'details', 'price', 'description', 'category_id'];

    // public function getRouteKeyName()
    // {
    //     return "slug";
    // }

    //Relacion uno a muchos inversa
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    //relacion muchos a muchos
    public function tags(){
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    // Relación polimórfica uno a varios
    // Un reporte pueden tener varias imagenes
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }
    

}
