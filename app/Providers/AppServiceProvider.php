<?php

namespace App\Providers;

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

        // Bagikan ke tampilan
        View::share([
            'footer' => $footer,
            'socialMedia' => $socialMedia,
            'settings' => $settings,
        ]);
    }
}
