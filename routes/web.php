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
Route::view('/jadwal_create', 'jadwal.create')->name('jadwal.create');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function(){
    Route::get('/soal_tes', [App\Http\Controllers\HomeController::class, 'soal_tes_show'])->name('soal_tes');
    // Route::get('/peserta', [App\Http\Controllers\HomeController::class, 'peserta_show'])->name('peserta');
    Route::get('/hasil', [App\Http\Controllers\HomeController::class, 'hasil_show'])->name('hasil');
    Route::get('/draft_soal_show', [App\Http\Controllers\HomeController::class, 'draft_soal_show'])->name('draft_soal');
});
