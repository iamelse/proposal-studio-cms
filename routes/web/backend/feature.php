<?php

use App\Http\Controllers\Web\BackEnd\FeatureController;
use Illuminate\Support\Facades\Route;

Route::get('/feature', [FeatureController::class, 'index'])->name('be.feature.index');
Route::get('/feature/create', [FeatureController::class, 'create'])->name('be.feature.create');
Route::post('/feature/store', [FeatureController::class, 'store'])->name('be.feature.store');
Route::get('/feature/{feature:slug}', [FeatureController::class, 'edit'])->name('be.feature.edit');
Route::put('/feature/{feature:slug}', [FeatureController::class, 'update'])->name('be.feature.update');
Route::delete('/feature/{feature:slug}', [FeatureController::class, 'destroy'])->name('be.feature.destroy');
Route::get('/feature/mass/destroy', [FeatureController::class, 'massDestroy'])->name('be.feature.mass.destroy');

Route::post('/feature/generate-slug', [FeatureController::class, 'generateSlug'])->name('be.feature.generate.slug');
