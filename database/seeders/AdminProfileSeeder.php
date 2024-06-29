<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $adminUsers = User::role('admin')->get();

        foreach ($adminUsers as $adminUser) {
            Admin::updateOrCreate(
                ['user_id' => $adminUser->id],
                ['position' => $faker->jobTitle]
            );
        }
    }
}
