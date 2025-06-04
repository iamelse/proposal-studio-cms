<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\BackEnd\EventController;

Route::get('/events', [EventController::class,'index'])->name('be.event.index');
Route::get('/events/create', [EventController::class,'create'])->name('be.event.create');
Route::post('/events/store', [EventController::class,'store'])->name('be.event.store');
Route::get('/events/{event:slug}/edit', [EventController::class,'edit'])->name('be.event.edit');
Route::put('/events/{event:slug}/update', [EventController::class,'update'])->name('be.event.update');
Route::delete('/events/{event:slug}/destroy', [EventController::class,'destroy'])->name('be.event.destroy');
Route::get('/events/mass-destroy', [EventController::class,'massDestroy'])->name('be.event.mass.destroy');
Route::post('/events/generate-slug', [EventController::class,'generateSlug'])->name('be.event.generate.slug');
