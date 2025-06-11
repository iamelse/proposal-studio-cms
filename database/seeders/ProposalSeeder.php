<?php

namespace Database\Seeders;

use App\Models\Proposal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            ['image' => 'https://picsum.photos/400/600?random=1'],
            ['image' => 'https://picsum.photos/400/600?random=2'],
            ['image' => 'https://picsum.photos/400/600?random=3'],
            ['image' => 'https://picsum.photos/400/600?random=4'],
            ['image' => 'https://picsum.photos/400/600?random=5'],
            ['image' => 'https://picsum.photos/400/600?random=6'],
            ['image' => 'https://picsum.photos/400/600?random=7'],
            ['image' => 'https://picsum.photos/400/600?random=8'],
            ['image' => 'https://picsum.photos/400/600?random=9'],
            ['image' => 'https://picsum.photos/400/600?random=10'],
        ];

        foreach ($images as $index => $data) {
            Proposal::create([
                'title' => 'Proposal Title ' . ($index + 1),
                'image' => $data['image'],
            ]);
        }
    }
}
