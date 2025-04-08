<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class JobPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Loop to create 5 job posts
        foreach (range(1, 5) as $index) {
            DB::table('job_posts')->insert([
                'title' => $faker->jobTitle, 
                'category' => $faker->word, 
                'location' => $faker->city,  
                'status' => 'active',
                'job_type' => $faker->randomElement(['full_time', 'part_time', 'internship']), 
                'salary_range' => $faker->numberBetween(30000, 120000),  
                'description' => $faker->paragraph,  
                'applied_before' => $faker->dateTimeBetween('-1 year', 'now'), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
