<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory()
            ->count(5)
            ->hasCategories(3)
            ->hasReservations(1)
            ->create();

        Book::factory()
            ->count(2)
            ->hasReservations(2)
            ->hasAttached('categories', ['category_id' => Category::all()->random()->id])
            ->create();

        Book::factory()
            ->count(2)
            ->hasReservations(2)
            ->hasAttached('categories', ['category_id' => Category::all()->random()->id])
            ->create();
        
    }
}
