<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// import model user
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // membuat file seeder
    //   php artisan make:seeder UserSeeder
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
        // untuk menjalankannya/memindahkan ke db nya :
        // php artisan db:seed --class=NamaFileSeedernya
    }
}
