<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author_id' => \App\Models\Author::factory(),
            'publication_date' => $this->faker->date(),
            'description' => $this->faker->paragraph(3),
            'page_count' => $this->faker->numberBetween(100, 1000)
        ];
    }
}
