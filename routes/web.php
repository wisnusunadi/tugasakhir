<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('beranda');
});
Route::view('/jadwal', 'jadwal.show')->name('jadwal');

// Route::view('/soal_tes', 'soal.tes.show')->name('soal.tes');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function(){
    Route::get('/jadwal_create', [App\Http\Controllers\JadwalController::class, 'jadwal_create'])->name('jadwal.create');
    Route::post('/jadwal_store', [App\Http\Controllers\JadwalController::class, 'jadwal_store'])->name('jadwal.store');
    Route::get('/soal_tes', [App\Http\Controllers\HomeController::class, 'soal_tes_show'])->name('soal_tes');
    Route::get('/peserta', [App\Http\Controllers\HomeController::class, 'peserta_show'])->name('peserta');
    Route::get('/hasil', [App\Http\Controllers\HomeController::class, 'hasil_show'])->name('hasil');
    Route::get('/draft_soal_show', [App\Http\Controllers\HomeController::class, 'draft_soal_show'])->name('draft_soal');
    Route::get('/draft_soal_create', [App\Http\Controllers\HomeController::class, 'draft_soal_create'])->name('draft_soal.create');
    Route::post('/draft_soal_store', [App\Http\Controllers\HomeController::class, 'draft_soal_store'])->name('draft_soal.store');
    Route::get('/draft_soal_preview/{id}', [App\Http\Controllers\HomeController::class, 'draft_soal_preview'])->name('draft_soal.preview');
    Route::get('/draft_soal_preview/data/{id}', [App\Http\Controllers\HomeController::class, 'draft_soal_preview_data'])->name('draft_soal.preview.data');
});
