<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Book;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $book_ids = Book::pluck('book_id');
        $user_ids = User::pluck('id');


        return [
            'user_id' => $this->faker->randomElement($user_ids),
            'book_id' => $this->faker->randomElement($book_ids)
        ];
    }
}
