<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

Route::get('/config-clear', function () {
    Artisan::call('config:clear');

    return response()->json([
       'message' => 'Config cleared successfully!',
    ]);
});

Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');

    return response()->json([
        'message'=> 'Cache cleared successfully!',
    ]);
});

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');

    return response()->json([
        'message'=> 'Optimized cleared successfully!',
    ]);
});

Route::get('/refresh-database', function () {

    Artisan::call('session:table');

    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true
    ]);

    return response()->json([
        'message' => 'Database refreshed successfully!',
    ]);
});

Route::get('/route-cache', function () {
    Artisan::call('permission:cache-reset');
    Artisan::call('route:cache');

    return response()->json([
        'message' => 'Routes cached successfully!',
    ]);
});

Route::get('/clear-caches', function () {
    // Clear config, route, cache
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');

    // Clear permission cache
    Artisan::call('permission:cache-reset');

    // (Optional) Cache again if you want
    // Artisan::call('config:cache');
    // Artisan::call('route:cache');

    return response()->json([
        'message' => 'Caches cleared and permission cache reset',
    ]);
});

Route::get('/debug-permissions', function () {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['error' => 'Not authenticated'], 401);
    }

    return response()->json([
        'roles' => $user->getRoleNames(),
        'permissions' => $user->getAllPermissions()->pluck('name'),
    ]);
});

Route::get('/dump-autoload', function () {
    try {
        $output = shell_exec('composer dump-autoload 2>&1');
        return response()->json([
            'message' => 'Composer dump-autoload executed successfully!',
            'output' => $output
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to execute composer dump-autoload!',
            'error' => $e->getMessage()
        ], 500);
    }
});
