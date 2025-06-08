<?php

namespace App\Providers;

use App\Models\QuickLink;
use App\Models\Section;
use App\Models\Setting;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $footer = Schema::hasTable('sections')
            ? Section::where('name', 'footer')->first()
            : null;

        $socialMedia = Schema::hasTable('social_media')
            ? SocialMedia::all()
            : collect([]);

        // Ambil pengaturan
        $settings = Schema::hasTable('settings')
            ? Setting::pluck('value', 'key')
            : collect();

        // Ambil nomor WhatsApp dari settings dan format dengan kode negara
        $whatsapp = $settings->get('whatsapp');
        $whatsapp_number_with_country_code = $whatsapp
            ? formatWhatsappNumber($whatsapp)
            : null;

        // Tambahkan nomor WhatsApp yang diformat ke dalam settings
        $settings->put('whatsapp_number_with_country_code', $whatsapp_number_with_country_code);

        // Bagikan ke tampilan
        View::share([
            'footer' => $footer,
            'socialMedia' => $socialMedia,
            'settings' => $settings,
        ]);
    }
}

/**
 * Format nomor WhatsApp menjadi format internasional untuk Indonesia (62).
 *
 * @param string $whatsapp
 * @return string|null
 */
function formatWhatsappNumber(?string $whatsapp): ?string
{
    // Bersihkan input dari karakter non-numerik, kecuali '+' untuk kode negara internasional
    $whatsapp = cleanWhatsappInput($whatsapp);

    // Proses berdasarkan kondisi
    if ($whatsapp) {
        // Jika nomor dimulai dengan '+', pastikan kode negara 62
        if (startsWithPlus($whatsapp)) {
            return formatWithCountryCode($whatsapp);
        }

        // Jika nomor diawali dengan '0', ganti dengan '62'
        if (startsWithZero($whatsapp)) {
            return '62' . substr($whatsapp, 1);
        }

        // Jika sudah dalam format internasional dengan kode negara 62
        if (startsWithCountryCode($whatsapp)) {
            return $whatsapp;
        }
    }

    return null; // Jika tidak valid, kembalikan null
}

/**
 * Bersihkan input WhatsApp dari karakter yang tidak diperlukan.
 *
 * @param string $input
 * @return string
 */
function cleanWhatsappInput(string $input): string
{
    return preg_replace('/[^0-9+]/', '', $input); // Hapus karakter non-numerik selain +
}

/**
 * Cek apakah nomor WhatsApp diawali dengan tanda '+'.
 *
 * @param string $number
 * @return bool
 */
function startsWithPlus(string $number): bool
{
    return strpos($number, '+') === 0;
}

/**
 * Format nomor WhatsApp yang diawali dengan tanda '+' menjadi format internasional (kode negara 62).
 *
 * @param string $number
 * @return string
 */
function formatWithCountryCode(string $number): string
{
    // Ganti tanda '+' dengan kode negara Indonesia '62'
    return preg_replace('/^\+62/', '62', $number);
}

/**
 * Cek apakah nomor WhatsApp sudah memiliki kode negara '62'.
 *
 * @param string $number
 * @return bool
 */
function startsWithCountryCode(string $number): bool
{
    return substr($number, 0, 2) === '62';
}

/**
 * Cek apakah nomor WhatsApp diawali dengan '0'.
 *
 * @param string $number
 * @return bool
 */
function startsWithZero(string $number): bool
{
    return substr($number, 0, 1) === '0';
}
