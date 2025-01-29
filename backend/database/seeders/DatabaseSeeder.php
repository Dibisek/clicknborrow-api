<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.pl',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@admin.pl',
            'password' => bcrypt('admin'),
            'is_admin' => true
        ]);

        Reservation::factory(5)->create();

        $this->call([
            BookSeeder::class,
        ]);

    }
}
