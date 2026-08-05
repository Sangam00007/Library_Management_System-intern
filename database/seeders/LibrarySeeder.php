<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Seeder;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect();
        for ($i = 0; $i < 5; $i++) {
            $categories->push(Category::firstOrCreate(
                ['name' => ucwords(fake()->unique()->words(2, true))],
                ['description' => fake()->sentence()]
            ));
        }

        $authors = collect();
        for ($i = 0; $i < 5; $i++) {
            $authors->push(Author::create([
                'name' => fake()->name(),
                'bio' => fake()->paragraph(),
            ]));
        }

        $publishers = collect();
        for ($i = 0; $i < 5; $i++) {
            $publishers->push(Publisher::create([
                'name' => fake()->company(),
                'address' => fake()->address(),
                'contact_number' => substr(fake()->phoneNumber(), 0, 20), // Truncate to avoid varchar limits if any, though usually 255
            ]));
        }

        for ($i = 0; $i < 5; $i++) {
            $totalCopies = fake()->numberBetween(10, 50);
            Book::create([
                'title' => ucwords(fake()->words(3, true)),
                'isbn' => fake()->unique()->isbn13(),
                'description' => fake()->paragraph(),
                'published_year' => fake()->year(),
                'language' => 'English',
                'total_copies' => $totalCopies,
                'available_copies' => fake()->numberBetween(0, $totalCopies),
                'category_id' => $categories->random()->id,
                'author_id' => $authors->random()->id,
                'publisher_id' => $publishers->random()->id,
            ]);
        }
    }
}
