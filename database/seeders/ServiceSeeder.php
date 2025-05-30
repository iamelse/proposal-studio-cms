<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Proposal Bisnis',
                'description' => 'Dokumen rinci yang merencanakan dan meyakinkan tentang potensi kesuksesan suatu bisnis.',
            ],
            [
                'title' => 'Proposal Kegiatan',
                'description' => 'Dokumen yang merinci rencana dan pelaksanaan suatu kegiatan atau acara untuk mendapatkan persetujuan dan dukungan.',
            ],
            [
                'title' => 'Proposal Sponsorship',
                'description' => 'Dokumen permohonan dukungan finansial dari sponsor untuk suatu acara atau inisiatif tertentu.',
            ],
            [
                'title' => 'Proposal Investasi',
                'description' => 'Dokumen yang merinci potensi keuntungan dan proyeksi keuangan suatu investasi untuk meyakinkan para investor.',
            ],
            [
                'title' => 'Proposal Kerjasama',
                'description' => 'Dokumen formal yang merinci tujuan, manfaat, dan syarat-syarat kerjasama antara pihak-pihak terlibat.',
            ],
            [
                'title' => 'Proposal Sewa Tempat',
                'description' => 'Dokumen permohonan dan rincian kontrak penyewaan untuk mendapatkan persetujuan penyewaan tempat.',
            ],
            [
                'title' => 'Proposal Penawaran Produk',
                'description' => 'Dokumen yang merinci informasi produk, harga, dan manfaat untuk mendapatkan persetujuan pembelian dari calon pelanggan.',
            ],
            [
                'title' => 'Company Profile',
                'description' => 'Dokumen ringkas yang menyajikan informasi mengenai identitas, visi, misi, nilai-nilai, dan pencapaian perusahaan.',
            ],
            [
                'title' => 'Curriculum Vitae',
                'description' => 'Ringkasan tertulis tentang latar belakang pendidikan, pengalaman kerja, dan keterampilan seseorang.',
            ],
        ];

        foreach ($services as $service) {
            Service::create([
                'title' => $service['title'],
                'description' => $service['description'],
                'image' => null,
            ]);
        }
    }
}
