<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => ucwords($this->faker->words(2, true)),
            'director_name' => $this->faker->name(),
            'release_year' => $this->faker->year(),
            'slug' => $this->faker->slug()
        ];
    }
}
