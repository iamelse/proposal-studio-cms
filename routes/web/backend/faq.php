<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\BackEnd\FAQController;

Route::get('/faqs', [FAQController::class,'index'])->name('be.faq.index');
Route::get('/faqs/create', [FAQController::class,'create'])->name('be.faq.create');
Route::post('/faqs/store', [FAQController::class,'store'])->name('be.faq.store');
Route::get('/faqs/{faq}/edit', [FAQController::class,'edit'])->name('be.faq.edit');
Route::put('/faqs/{faq}/update', [FAQController::class,'update'])->name('be.faq.update');
Route::delete('/faqs/{faq}/destroy', [FAQController::class,'destroy'])->name('be.faq.destroy');
Route::get('/faqs/mass-destroy', [FAQController::class,'massDestroy'])->name('be.faq.mass.destroy');
