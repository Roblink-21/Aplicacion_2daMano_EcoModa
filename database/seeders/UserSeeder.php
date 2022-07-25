<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Roberth',
            'last_name' => 'Pincha',
            'username' => 'Admin',
            'personal_phone' => '0994567821',
            'home_phone' => '025748963',
            'address' => 'Av. Mariscal Sucre y La Gasca, CO80810',
            'password' => bcrypt('12345678'),
            'email' => 'rob@epn.edu.ec',
            'birthdate' => '1992-10-12',
            'score' => '3',
        ]);
        $users = User::factory(30)->create();
    }
}