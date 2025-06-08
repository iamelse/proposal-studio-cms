<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apakah bisa membuat proposal skripsi?',
                'answer' => 'Maaf Kak, kami tidak menerima pembuatan proposal dalam ranah pendidikan/sekolah/kuliah seperti proposal skripsi, proposal penelitian, makalah, dan lainnya yang menyangkut dengan pendidikan.',
            ],
            [
                'question' => 'Saya gatau apa-apa soal Proposal, apakah bisa dibantu sampai tuntas?',
                'answer' => 'Bisa Kak, tenang saja kita akan bantu dari awal sampai akhir sesuai dengan kebutuhan Kakak. Kita juga ada KONSULTASI GRATIS kak, jadi Kakak bisa konsultasi sampai tuntas dengan kami.',
            ],
            [
                'question' => 'Bisa buat proposal dalam waktu cepat?',
                'answer' => 'Bisa Kak, pengerjaan kami hanya membutuhkan waktu 1-7 hari kerja saja.',
            ],
            [
                'question' => 'Apakah proposal saya aman / tidak disebarluaskan?',
                'answer' => 'Proposal 100% aman Kak, kami juga menyediakan Surat Perjanjian Kerjasama dalam menjaga keamanan data maupun proposalnya jika dibutuhkan.',
            ],
            [
                'question' => 'Apakah boleh tanya-tanya terlebih dahulu?',
                'answer' => 'Boleh Kak silahkan, dengan senang hati kami akan membantu. Kami akan lebih fast respon di Whatsapp dibandingkan di DM Instagram. Jadi silahkan kontak Whatsapp kami saja ya Kak untuk konsultasi/tanya-tanya terlebih dahulu.',
            ],
        ];

        DB::table('f_a_q_s')->insert($faqs);
    }
}
