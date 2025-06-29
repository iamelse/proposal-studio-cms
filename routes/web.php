<?php

use App\Http\Controllers\Web\FrontEnd\WhatsappRedirectController;
use Illuminate\Support\Facades\Route;

/**
 * Web routes auth
 */
Route::prefix('auth')->group(function () {
    include __DIR__.'/web/auth/auth.php';
});

/**
 * Web routes backend
 */
Route::prefix('admin')->middleware('is.auth')->group(function () {
    include __DIR__ .'/web/backend/dashboard.php';

    include __DIR__ . '/web/backend/our-service.php';
    include __DIR__ . '/web/backend/feature.php';
    include __DIR__ . '/web/backend/proposal.php';
    include __DIR__ . '/web/backend/event.php';
    include __DIR__ . '/web/backend/review.php';
    include __DIR__ . '/web/backend/faq.php';
    include __DIR__ . '/web/backend/role.php';
    include __DIR__ . '/web/backend/user.php';
    include __DIR__ . '/web/backend/social-media.php';
    include __DIR__. '/web/backend/post-category.php';
    include __DIR__. '/web/backend/post.php';

    Route::group([
        'prefix'     => '/laravel-filemanager',
        'middleware' => ['web', 'auth'],
    ], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    include __DIR__ . '/web/backend/user-profile.php';

    include __DIR__ . '/web/backend/home.php';
    include __DIR__ . '/web/backend/settings.php';
});

/**
 * Web routes frontend
 */
include __DIR__ . '/web/frontend/web.php';


Route::get('/konsultasi-gratis', WhatsappRedirectController::class)
    ->middleware('throttle:20,1')   // limit → kurangi spam bot
    ->name('wa.redirect');


if (app()->environment(['local', 'staging'])) {
    include __DIR__ . '/dev-idcloudhost.php';
}
