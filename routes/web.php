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
Route::get('/select/universitas', [App\Http\Controllers\GetController::class, 'universitas_select'])->name('select.universitas');
Route::get('jadwal/show',  [App\Http\Controllers\JadwalController::class, 'jadwal_show'])->name('jadwal.show');
Route::get('/user/verify/{token}', [App\Http\Controllers\Auth\RegisterController::class, 'verifyUser'])->name('verify_user');

// Route::view('/soal_tes', 'soal.tes.show')->name('soal.tes');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => '/jadwal'], function () {
        Route::get('/create', [App\Http\Controllers\JadwalController::class, 'jadwal_create'])->name('jadwal.create');
        Route::get('/edit/{id}', [App\Http\Controllers\JadwalController::class, 'jadwal_edit'])->name('jadwal.edit');
        Route::post('/store', [App\Http\Controllers\JadwalController::class, 'jadwal_store'])->name('jadwal.store');
        Route::put('/update/{id}', [App\Http\Controllers\JadwalController::class, 'jadwal_update'])->name('jadwal.update');
    });
    Route::get('/peserta', [App\Http\Controllers\HomeController::class, 'peserta_show'])->name('peserta');
    Route::get('/hasil', [App\Http\Controllers\HomeController::class, 'hasil_show'])->name('hasil');
    Route::view('/hasil/peserta', 'peserta.hasil.show_result')->name('peserta.hasil');
    Route::get('/hasil/peserta/export', [App\Http\Controllers\HomeController::class, 'export_hasil_keputusan'])->name('peserta.hasil.export');
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
        Route::get('/result/{soal}/{user}', [App\Http\Controllers\HomeController::class, 'soal_tes_result'])->name('soal_tes.result');
    });
    Route::group(['prefix' => '/divisi'], function () {
        Route::view('/show', 'divisi.show')->name('divisi.show');
        Route::view('/create', 'divisi.create')->name('divisi.create');
        Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, 'divisi_edit'])->name('divisi.edit');
        Route::put('/update/{id}', [App\Http\Controllers\HomeController::class, 'divisi_update'])->name('divisi.update');
        Route::post('/store', [App\Http\Controllers\HomeController::class, 'divisi_store'])->name('divisi.store');
        Route::delete('/delete', [App\Http\Controllers\HomeController::class, 'divisi_delete'])->name('divisi.delete');
    });
    Route::group(['prefix' => '/jabatan'], function () {
        Route::view('/show', 'jabatan.show')->name('jabatan.show');
        Route::view('/create', 'jabatan.create')->name('jabatan.create');
        Route::get('/edit/{id}', [App\Http\Controllers\HomeController::class, 'jabatan_edit'])->name('jabatan.edit');
        Route::put('/update/{id}', [App\Http\Controllers\HomeController::class, 'jabatan_update'])->name('jabatan.update');
        Route::post('/store', [App\Http\Controllers\HomeController::class, 'jabatan_store'])->name('jabatan.store');
        Route::delete('/delete', [App\Http\Controllers\HomeController::class, 'jabatan_delete'])->name('jabatan.delete');
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
        Route::delete('/delete', [App\Http\Controllers\HomeController::class, 'draft_soal_delete'])->name('draft_soal.delete');
    });
    Route::group(['prefix' => '/laporan'], function () {
        Route::get('/hasil/show', [App\Http\Controllers\HomeController::class, 'laporan_hasil_show'])->name('laporan.hasil.show');
        Route::get('/hasil/export', [App\Http\Controllers\HomeController::class, 'laporan_hasil_export'])->name('laporan.hasil.export');
    });
});
