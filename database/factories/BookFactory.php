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
            "name" => $this->faker->company(),
            "isbn" => $this->faker->isbn13(),
            "authors" => [
                $this->faker->name()
            ],
            "country" => $this->faker->country(),
            "number_of_pages" => rand(100, 999),
            "publisher" => $this->faker->name(),
            "release_date" => $this->faker->dateTime->format('Y-m-d'),
        ];
    }
}
