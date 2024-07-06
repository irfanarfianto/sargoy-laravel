<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visit;
use Carbon\Carbon;
use Faker\Factory as Faker;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Generate visits for the last 3 months
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();

        // Generate visits for each day in the period
        while ($startDate->lessThanOrEqualTo($endDate)) {
            // Generate a random number of visits for the day
            $visitCount = rand(1, 50);
            for ($i = 0; $i < $visitCount; $i++) {
                Visit::create([
                    'created_at' => $faker->dateTimeBetween($startDate->toDateTimeString(), $startDate->endOfDay()->toDateTimeString()),
                    'updated_at' => $faker->dateTimeBetween($startDate->toDateTimeString(), $startDate->endOfDay()->toDateTimeString()),
                    'ip_address' => $faker->ipv4,
                    'user_agent' => $faker->userAgent,
                ]);
            }
            $startDate->addDay();
        }
    }
}
