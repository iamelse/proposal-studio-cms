<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialMedias = [
            ['name' => 'Instagram', 'icon' => 'bx bxl-instagram', 'url' => 'https://www.instagram.com/proposalstudio'],
            ['name' => 'Facebook', 'icon' => 'bx bxl-facebook', 'url' => 'https://web.facebook.com/people/Proposal-Studio/100087161541087'],
            ['name' => 'TikTok', 'icon' => 'bx bxl-tiktok', 'url' => 'https://www.tiktok.com/@proposalstudio'],
        ];

        foreach ($socialMedias as &$socialMedia) {
            $socialMedia['slug'] = Str::slug($socialMedia['name']);
        }

        SocialMedia::insert($socialMedias);
    }
}
