<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\PostCategory;
use Carbon\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $faker = $this->faker;

        $createdAt = $faker->dateTimeBetween('-6 months', 'now');

        return [
            'cover' => 'https://picsum.photos/400/250?random=' . $faker->numberBetween(1, 1000),
            'title' => $faker->unique()->sentence,
            'slug' => $faker->unique()->slug,
            'excerpt' => $faker->paragraphs(1, true),
            'body' => $faker->paragraphs(10, true),
            'post_category_id' => PostCategory::inRandomOrder()->value('id'),
            'user_id' => User::factory(),
            'published_at' => $createdAt,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
            'status' => $faker->randomElement(['draft', 'published']),
            'seo_title' => $faker->unique()->sentence,
            'seo_description' => $faker->paragraphs(3, true),
            'seo_keywords' => $faker->words(5, true),
        ];
    }
}
