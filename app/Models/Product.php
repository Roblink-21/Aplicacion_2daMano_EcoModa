<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
