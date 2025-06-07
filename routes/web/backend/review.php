<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\BackEnd\ReviewController;

Route::get('/reviews', [ReviewController::class,'index'])->name('be.review.index');
Route::get('/reviews/create', [ReviewController::class,'create'])->name('be.review.create');
Route::post('/reviews/store', [ReviewController::class,'store'])->name('be.review.store');
Route::get('/reviews/{review}/edit', [ReviewController::class,'edit'])->name('be.review.edit');
Route::put('/reviews/{review}/update', [ReviewController::class,'update'])->name('be.review.update');
Route::delete('/reviews/{review}/destroy', [ReviewController::class,'destroy'])->name('be.review.destroy');
Route::get('/reviews/mass-destroy', [ReviewController::class,'massDestroy'])->name('be.review.mass.destroy');
Route::post('/reviews/generate-slug', [ReviewController::class,'generateSlug'])->name('be.review.generate.slug');
