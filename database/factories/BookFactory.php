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
            'author' => $this->faker->name(),
            'published_year' => $this->faker->numberBetween(1950, (int) date('Y')),
            'isbn' => strtoupper($this->faker->unique()->bothify('??-########')),
            'stock' => $this->faker->numberBetween(0, 20),
        ];
    }
}
