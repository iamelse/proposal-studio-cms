<?php

use App\Http\Controllers\Web\BackEnd\Home\AboutController;
use App\Http\Controllers\Web\BackEnd\Home\CallToActionController;
use App\Http\Controllers\Web\BackEnd\Home\FooterController;
use App\Http\Controllers\Web\BackEnd\Home\HeroController;
use App\Http\Controllers\Web\BackEnd\Home\OurServiceController;
use App\Http\Controllers\Web\BackEnd\Home\ProposalController;
use App\Http\Controllers\Web\BackEnd\Home\EventController;
use App\Http\Controllers\Web\BackEnd\Home\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/home/hero', [HeroController::class,'index'])->name('be.home.hero.index');
Route::put('/home/hero/update', [HeroController::class,'update'])->name('be.home.hero.update');

Route::get('/home/about', [AboutController::class,'index'])->name('be.home.about.index');
Route::put('/home/about/update', [AboutController::class,'update'])->name('be.home.about.update');

Route::get('/our-service', [OurServiceController::class, 'index'])->name('be.home.our-service.index');
Route::put('/our-service/update', [OurServiceController::class, 'update'])->name('be.home.our-service.update');

Route::get('/proposal', [ProposalController::class, 'index'])->name('be.home.proposal.index');
Route::put('/proposal/update', [ProposalController::class, 'update'])->name('be.home.proposal.update');

Route::get('/event', [EventController::class, 'index'])->name('be.home.event.index');
Route::put('/event/update', [EventController::class, 'update'])->name('be.home.event.update');

Route::get('/review', [ReviewController::class, 'index'])->name('be.home.review.index');
Route::put('/review/update', [ReviewController::class, 'update'])->name('be.home.review.update');

Route::get('/home/cta', [CallToActionController::class,'index'])->name('be.home.cta.index');
Route::put('/home/cta/update', [CallToActionController::class,'update'])->name('be.home.cta.update');

Route::get('/home/footer', [FooterController::class,'index'])->name('be.home.footer.index');
Route::put('/home/footer/update', [FooterController::class,'update'])->name('be.home.footer.update');
