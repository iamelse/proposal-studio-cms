<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostViewStatistic>
 */
class PostViewStatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            //'views' => $this->faker->numberBetween(0, 1000),
            'views' => 0
        ];
    }
}
