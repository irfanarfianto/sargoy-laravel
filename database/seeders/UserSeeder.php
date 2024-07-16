<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'Susanti',
            'email' => 'susanti@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('seller');

        // $user = User::create([
        //     'name' => 'Seller ke 2',
        //     'email' => 'seller2@gmail.com',
        //     'password' => bcrypt('password'),
        //     'email_verified_at' => now(),
        // ]);
        // $user->assignRole('seller');

        $user2 = User::create([
            'name' => 'Jhon',
            'email' => 'jhon@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $user2->assignRole('visitor');

        // User::factory()->count(15)->create();
    }
}
