<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CourseSeeder::class);

        User::factory()->create([
            'name' => 'Ammar Mohamed Ali',
            'date_of_birth' => '1999-01-01',
            'password' => bcrypt('11111111'),
            'email_verified_at' => now(),
            'email' => 'ammar@gmail.com',
            'phone_number' => '01129264191',
            'is_instructor' => false,
        ]);
    }
}
