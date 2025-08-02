<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Category::factory(5)->create();
        JobType::factory(5)->create();
        Job::factory(20)->create(); 
        JobApplication::factory(20)->create();
    }
}
