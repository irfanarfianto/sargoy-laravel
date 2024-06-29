<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SellerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $sellerUsers = User::role('seller')->get();

        foreach ($sellerUsers as $sellerUser) {
            Seller::updateOrCreate(
                ['user_id' => $sellerUser->id],
                [
                    'no_wa' => $faker->phoneNumber,
                    'alamat' => $faker->address
                ]
            );
        }
    }
}
