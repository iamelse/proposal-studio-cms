<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\BackEnd\ProposalsController;

Route::get('/proposals', [ProposalsController::class,'index'])->name('be.proposal.index');
Route::get('/proposals/create', [ProposalsController::class,'create'])->name('be.proposal.create');
Route::post('/proposals/store', [ProposalsController::class,'store'])->name('be.proposal.store');
Route::get('/proposals/{proposal:slug}/edit', [ProposalsController::class,'edit'])->name('be.proposal.edit');
Route::put('/proposals/{proposal:slug}/update', [ProposalsController::class,'update'])->name('be.proposal.update');
Route::delete('/proposals/{proposal:slug}/destroy', [ProposalsController::class,'destroy'])->name('be.proposal.destroy');
Route::get('/proposals/mass-destroy', [ProposalsController::class,'massDestroy'])->name('be.proposal.mass.destroy');
Route::post('/proposals/generate-slug', [ProposalsController::class,'generateSlug'])->name('be.proposal.generate.slug');
