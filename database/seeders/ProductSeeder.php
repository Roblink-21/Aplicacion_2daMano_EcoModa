<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = Product::factory(62)->create();

        foreach($products as $product){
            $product->tags()->attach([
                rand(1,4),
                rand(5,8)
            ]);
        }

    }

}