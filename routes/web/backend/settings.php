<?php

use App\Http\Controllers\Web\BackEnd\Setting\GeneralSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/settings/general', [GeneralSettingController::class,'index'])->name('be.settings.general.index');
Route::put('/settings/general/update', [GeneralSettingController::class,'update'])->name('be.settings.general.update');
