<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EnquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            DB::table('enquiries')->insert([
                'name' => fake()->name(),
                'mobile' => fake()->numerify('9#########'),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'vendor',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }

        for ($i = 1; $i <= 15; $i++) {
            DB::table('enquiries')->insert([
                'name' => fake()->name(),
                'mobile' => fake()->numerify('9#########'),
                'email' => fake()->unique()->safeEmail(),
                'role' => 'delivery',
                'status' => 'pending',
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }


    }
}
