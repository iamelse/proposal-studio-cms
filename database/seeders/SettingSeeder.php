<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('settings')->insert([
            [
                'key' => 'working_hours',
                'value' => '08.00 WIB - 17.00 WIB',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'off_days',
                'value' => 'Sabtu, Minggu, dan Tanggal Merah libur',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'whatsapp',
                'value' => '0812-2683-1649',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'email',
                'value' => 'contactproposalstudio@gmail.com',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'site_logo',
                'value' => asset('assets/images/logo.svg'), // Ganti path sesuai kebutuhan
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'og_image_home',
                'value' => null, // Ganti path sesuai kebutuhan
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'og_image_post_index',
                'value' => null, // Ganti path sesuai kebutuhan
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'home_title',
                'value' => 'Selamat Datang di Nama Website',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'home_description',
                'value' => 'Deskripsi singkat untuk halaman utama situs',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'post_index_title',
                'value' => 'Artikel & Berita Terbaru',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'key' => 'post_index_description',
                'value' => 'Deskripsi untuk halaman artikel/blog',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
