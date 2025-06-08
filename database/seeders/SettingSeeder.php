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
            ['key' => 'working_hours', 'value' => '08.00 WIB - 17.00 WIB', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'off_days', 'value' => 'Sabtu, Minggu, dan Tanggal Merah libur', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'whatsapp', 'value' => '0812-2683-1649', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'email', 'value' => 'contactproposalstudio@gmail.com', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
