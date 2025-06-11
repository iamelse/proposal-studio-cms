<?php

namespace Database\Seeders;

use App\Models\WhyUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WhyUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $whyUsList = [
            [
                'icon' => 'bx bx-check-circle',
                'title' => 'Terpercaya',
                'image' => 'https://picsum.photos/200/200?random=1'
            ],
            [
                'icon' => 'bx bx-user',
                'title' => 'Tim Profesional',
                'image' => 'https://picsum.photos/200/200?random=2'
            ],
            [
                'icon' => 'bx bx-time-five',
                'title' => 'Pengerjaan Cepat',
                'image' => 'https://picsum.photos/200/200?random=3'
            ],
            [
                'icon' => 'bx bx-conversation',
                'title' => 'Gratis Konsultasi',
                'image' => 'https://picsum.photos/200/200?random=4'
            ],
            [
                'icon' => 'bx bx-refresh',
                'title' => 'Bebas Revisi',
                'image' => 'https://picsum.photos/200/200?random=5'
            ],
            [
                'icon' => 'bx bx-smile',
                'title' => 'Pelayanan Ramah',
                'image' => 'https://picsum.photos/200/200?random=6'
            ],
        ];

        foreach ($whyUsList as $why) {
            WhyUs::create([
                'icon' => $why['icon'],
                'title' => $why['title'],
                'slug' => Str::slug($why['title']),
                'image' => $why['image'],
            ]);
        }
    }
}
