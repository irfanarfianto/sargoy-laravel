<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo seller
        $demoSeller = User::create([
            'name' => 'Demo Seller',
            'email' => 'demoseller@gmail.com',
            'password' => Hash::make('password')
        ]);
        $demoSeller->assignRole('demo_seller');

        // Create demo admin
        $demoAdmin = User::create([
            'name' => 'Demo Admin',
            'email' => 'demoadmin@gmail.com',
            'password' => Hash::make('password')
        ]);
        $demoAdmin->assignRole('demo_admin');
    }
}
