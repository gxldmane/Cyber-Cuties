<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Follower;
use App\Models\Rank;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceTypes;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserMedia;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(10)->create();
        Rank::factory(100)->create();
        User::factory(100)->create();
        UserMedia::factory(250)->create();
        Service::factory(100)->create();
        ServiceTypes::factory(200)->create();
        Follower::factory(250)->create();
        Review::factory(100)->create();
    }
}
