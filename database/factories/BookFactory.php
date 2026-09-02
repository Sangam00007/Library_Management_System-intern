<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Book>
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
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'isbn' => fake()->unique()->isbn13(),
            'description' => fake()->paragraph(),
            'published_year' => fake()->year(),
            'language' => 'english',
            'total_copies' => fake()->numberBetween(1, 10),
            'available_copies' => fake()->numberBetween(0, 5),
            'category_id' => Category::factory(),
            'author_id' => Author::factory(),
            'publisher_id' => Publisher::factory(),
            'slug' => Str::slug($title),
        ];
    }
}
