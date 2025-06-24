<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostViewStatistic;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);

        // Create Master user
        $master = User::factory()->create([
            'name' => 'Master',
            'username' => 'master',
            'email' => 'master@example.com',
            'email_verified_at' => now(),
        ]);
        $master->assignRole(RoleEnum::MASTER->value);

        // Create Author user
        $author = User::factory()->create([
            'name' => 'Author',
            'username' => 'author',
            'email' => 'author@example.com',
            'email_verified_at' => now(),
        ]);
        $author->assignRole(RoleEnum::AUTHOR->value);

        // Role::factory()->count(100)->create();
        // User::factory()->count(100)->create();
        // PostCategory::factory()->count(5)->create();
        // Post::factory()->count(50)->create();
        /**
        Post::factory()
            ->count(50)
            ->create()
            ->each(function ($post) {
                foreach (range(1, 30) as $i) {
                    $date = now()->subDays(30 - $i);
                    PostViewStatistic::factory()->create([
                        'post_id' => $post->id,
                        'date' => $date->toDateString(), // ✅ gunakan 'date' bukan 'viewed_at'
                        'views' => rand(10, 300),
                        //'views' => 0
                    ]);
                }
            });
         **/

        $this->call(SectionSeeder::class);
        $this->call(SocialMediaSeeder::class);
        $this->call(WhyUsSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ProposalSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(FAQSeeder::class);
        $this->call(SettingSeeder::class);
        // $this->call(VisitorStatisticSeeder::class);
    }
}
