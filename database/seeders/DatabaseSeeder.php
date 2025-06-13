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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Mufida Rahma',
            'username' => 'admin',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);

        $this->call(PermissionSeeder::class);

        $user = User::find(1);
        $user->assignRole(RoleEnum::MASTER->value);

        Role::factory()->count(100)->create();
        User::factory()->count(100)->create();
        PostCategory::factory()->count(5)->create();
        // Post::factory()->count(50)->create();
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

        $this->call(SectionSeeder::class);
        $this->call(SocialMediaSeeder::class);
        $this->call(WhyUsSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ProposalSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(FAQSeeder::class);
        $this->call(SettingSeeder::class);
    }
}
