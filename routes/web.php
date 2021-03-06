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

Route::get('jadwal/show',  [App\Http\Controllers\JadwalController::class, 'jadwal_show'])->name('jadwal.show');
// Route::view('/soal_tes', 'soal.tes.show')->name('soal.tes');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => '/jadwal'], function () {

        Route::get('/create', [App\Http\Controllers\JadwalController::class, 'jadwal_create'])->name('jadwal.create');
        Route::post('/store', [App\Http\Controllers\JadwalController::class, 'jadwal_store'])->name('jadwal.store');
    });
    Route::get('/peserta', [App\Http\Controllers\HomeController::class, 'peserta_show'])->name('peserta');
    Route::get('/hasil', [App\Http\Controllers\HomeController::class, 'hasil_show'])->name('hasil');
    Route::group(['prefix' => '/select'], function () {
        Route::get('/jabatan/get/{id}', [App\Http\Controllers\HomeController::class, 'select_jabatan_get'])->name('select.jabatan.get');
        Route::get('/divisi/get/{id}', [App\Http\Controllers\HomeController::class, 'select_divisi_get'])->name('select.divisi.get');
        Route::get('/jabatan', [App\Http\Controllers\HomeController::class, 'select_jabatan'])->name('select.jabatan');
        Route::get('/divisi', [App\Http\Controllers\HomeController::class, 'select_divisi'])->name('select.divisi');
    });
    Route::group(['prefix' => '/soal_tes'], function () {
        Route::post('/store', [App\Http\Controllers\HomeController::class, 'soal_tes_store'])->name('soal_tes.store');
        Route::get('/preview', [App\Http\Controllers\HomeController::class, 'soal_tes_preview'])->name('soal_tes.preview');
        Route::get('/show/{id}', [App\Http\Controllers\HomeController::class, 'soal_tes_show'])->name('soal_tes.show');
    });
    Route::group(['prefix' => '/draft_soal'], function () {
        Route::get('/show', [App\Http\Controllers\HomeController::class, 'draft_soal_show'])->name('draft_soal');
        Route::get('/data', [App\Http\Controllers\HomeController::class, 'draft_soal_data'])->name('draft_soal.data');
        Route::get('/create', [App\Http\Controllers\HomeController::class, 'draft_soal_create'])->name('draft_soal.create');
        Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, 'draft_soal_edit'])->name('draft_soal.edit');
        Route::post('/store', [App\Http\Controllers\HomeController::class, 'draft_soal_store'])->name('draft_soal.store');
        Route::put('/update/{id}', [App\Http\Controllers\HomeController::class, 'draft_soal_update'])->name('draft_soal.update');
        Route::get('/search', [App\Http\Controllers\HomeController::class, 'draft_soal_search'])->name('draft_soal.search');
        Route::get('/preview/{id}', [App\Http\Controllers\HomeController::class, 'draft_soal_preview'])->name('draft_soal.preview');
        Route::get('/preview/data/{id}', [App\Http\Controllers\HomeController::class, 'draft_soal_preview_data'])->name('draft_soal.preview.data');
    });
});
