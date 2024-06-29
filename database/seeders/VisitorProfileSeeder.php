<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class VisitorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $visitorUsers = User::role('visitor')->get();

        foreach ($visitorUsers as $visitorUser) {
            Visitor::updateOrCreate(
                ['user_id' => $visitorUser->id],
                [
                    'no_wa' => $faker->phoneNumber,
                    'alamat' => $faker->address,
                    'birthdate' => $faker->date,
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'bio' => $faker->paragraph
                ]
            );
        }
    }
}
