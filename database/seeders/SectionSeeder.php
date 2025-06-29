<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'name' => 'hero',
                'content' => json_encode([
                    'title' => '<span style="color:rgb(31,35,40);">Realisasikan Tujuanmu Bersama</span>
                    <span style="color:rgb(5,64,140);">PROPOSAL</span>
                    <span style="color:rgb(202,84,25);">STUDIO</span>',
                    'subtitle' => 'JASA PROPOSAL PROFESIONAL',
                    'description' => '<span style="color:#1f2328;">
                            “Percayakan kesuksesan proposal Anda kepada kami.
                            Tim profesional dan berpengalaman dari kami akan
                            membantu Anda meraih kesuksesan yang lebih besar”
                          </span>'
                ])
            ],
            [
                    'name' => 'about',
                    'content' => json_encode([
                        'title' => '<span style="color:#05408C;">PROPOSAL</span> <span style="color:#CA5419;">STUDIO</span> Keberhasilan project Anda adalah prioritas kami',
                        'image' => 'null',
                        'description' => 'Proposal Studio adalah jasa pembuatan proposal komersial yang berdiri sejak Januari, 2022. Kami telah dipercaya mengerjakan banyak project regional maupun project nasional oleh bermacam perusahaan, lembaga, event organizer, business owner, cerative agency, dan influencer. Kami juga telah dipercaya mengisi materi proposal di organisasi maupun komunitas di beberapa kampus ternama di Indonesia.',
                        'stats' => [
                            [
                                'title' => 'Projek Selesai',
                                'value' => '250',
                                'suffix' => '+'
                            ],
                            [
                                'title' => 'Pengalaman Kerja',
                                'value' => '2',
                                'suffix' => 'Tahun+'
                            ],
                            [
                                'title' => 'Klien Puas',
                                'value' => '99',
                                'suffix' => '%'
                            ]
                        ]
                    ])
            ],
            [
                'name' => 'proposal',
                'content' => json_encode([
                    'title' => 'Preview Proposal High Quality',
                    'subtitle' => 'Proyek-proyek Berkualitas yang Telah Kami Selesaikan dengan Penuh Keberhasilan.',
                ])
            ],
            [
                'name' => 'services',
                'content' => json_encode([
                    'title' => 'Mewujudkan Ide Brilian Anda Melalui Proposal Yang Mengesankan',
                    'subtitle' => 'Temukan Layanan Profesional yang Tepat di Proposal Studio.',
                ]),
            ],
            [
                'name' => 'event',
                'content' => json_encode([
                    'title' => 'Kegiatan Terkini Kami',
                    'subtitle' => 'Dapatkan Wawasan Mendalam melalui Serangkaian Kegiatan, Termasuk Webinar Terbaru Kami yang Penuh Informasi.',
                ])
            ],
            [
                'name' => 'review',
                'content' => json_encode([
                    'title' => 'Proposal Studio telah memiliki banyak <span style="color:#05408C;">testimoni positif</span> dari klien',
                    'subtitle' => '',
                ])
            ],
            [
                'name' => 'faq',
                'content' => json_encode([
                    'title' => 'Memiliki Pertanyaan? Temukan <span style="color:#05408C;">jawabannya</span> secara mudah di FAQ kami',
                    'subtitle' => '',
                ])
            ],
            [
                'name' => 'cta',
                'content' => json_encode([
                    'title' => '<span style="color:rgb(255,255,255);">Konsultasikan secara </span><span style="color:rgb(202,84,25);">GRATIS</span><span style="color:rgb(255,255,255);"> proposal Anda dan segera realisasikan tujuan Anda Bersama Kami</span>',
                ])
            ],
            ['name' => 'footer', 'content' => json_encode(['title' => 'About Me', 'description' => "Passionate web developer specializing in Laravel, Vue.js, and modern web technologies. Let's build something amazing together!"])],
            ['name' => 'about-page.about', 'content' => ''],
            ['name' => 'resume-page.resume', 'content' => ''],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(['name' => $section['name']], $section);
        }
    }
}
