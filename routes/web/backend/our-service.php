<?php

use App\Http\Controllers\Web\BackEnd\OurServiceListController;
use Illuminate\Support\Facades\Route;

Route::get('/our-service-list', [OurServiceListController::class, 'index'])->name('be.our-service-list.index');
Route::get('/our-service-list/create', [OurServiceListController::class, 'create'])->name('be.our-service-list.create');
Route::post('/our-service-list/store', [OurServiceListController::class, 'store'])->name('be.our-service-list.store');
Route::get('/our-service-list/{service:slug}', [OurServiceListController::class, 'edit'])->name('be.our-service-list.edit');
Route::put('/our-service-list/{service:slug}', [OurServiceListController::class, 'update'])->name('be.our-service-list.update');
Route::post('/our-service-list/mass-update', [OurServiceListController::class, 'massUpdate'])->name('be.our-service-list.mass.update');
Route::delete('/our-service-list/{service:slug}', [OurServiceListController::class, 'destroy'])->name('be.our-service-list.destroy');
Route::get('/our-service-list/mass/destroy', [OurServiceListController::class, 'massDestroy'])->name('be.our-service-list.mass.destroy');

Route::post('/our-service-list/generate-slug', [OurServiceListController::class, 'generateSlug'])->name('be.our-service-list.generate.slug');
