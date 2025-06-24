<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WhatsappRedirectController extends Controller
{
    public function __invoke()
    {
        // 1. Ambil dan format nomor WhatsApp dari setting
        $setting = Setting::where('key', 'whatsapp')->first();
        $rawNumber = $setting?->value;

        if (!$rawNumber) {
            abort(404, 'Nomor WhatsApp tidak ditemukan.');
        }

        $number = $this->formatWhatsappNumber($rawNumber);

        if (!$number) {
            abort(400, 'Format nomor WhatsApp tidak valid.');
        }

        // 2. Simpan statistik klik (PostgreSQL-safe)
        $today = Carbon::today()->toDateString();

        $exists = DB::table('whatsapp_click_statistics')->where('date', $today)->exists();

        if ($exists) {
            DB::table('whatsapp_click_statistics')
                ->where('date', $today)
                ->increment('clicks');
        } else {
            DB::table('whatsapp_click_statistics')->insert([
                'date'       => $today,
                'clicks'     => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Redirect ke WhatsApp
        $text = urlencode('Hallo Kak, saya ingin tanya terkait proposal, apakah bisa dibantu?');
        return redirect()->away("https://wa.me/{$number}?text={$text}");
    }

    /**
     * Format nomor WhatsApp menjadi format internasional (kode negara 62).
     */
    private function formatWhatsappNumber(string $input): ?string
    {
        // Hapus semua karakter selain angka
        $number = preg_replace('/[^0-9]/', '', $input);

        if (!$number) {
            return null;
        }

        // Jika dimulai dengan 0, ubah ke 62
        if (str_starts_with($number, '0')) {
            return '62' . substr($number, 1);
        }

        // Jika sudah mulai dengan 62, gunakan langsung
        if (str_starts_with($number, '62')) {
            return $number;
        }

        // Kalau tidak keduanya, asumsikan nomor salah
        return null;
    }
}
