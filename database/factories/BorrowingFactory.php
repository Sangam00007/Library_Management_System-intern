<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowDate = fake()->dateTimeBetween('-3 months', 'now');

        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'borrow_date' => $borrowDate,
            'due_date' => fake()->dateTimeBetween($borrowDate, '+1 month'),
            'return_date' => null,
            'status' => 'issued',
        ];
    }

    /**
     * Indicate that the borrowing has been returned.
     */
    public function returned(): static
    {
        return $this->state(fn (array $attributes) => [
            'return_date' => fake()->dateTimeBetween($attributes['borrow_date'], 'now'),
            'status' => 'returned',
        ]);
    }
}
