<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/jabatan', [App\Http\Controllers\HomeController::class, 'jabatan_data']);
Route::get('/divisi', [App\Http\Controllers\HomeController::class, 'divisi_data']);
// Route::get('/jadwal/table', [App\Http\Controllers\HomeController::class, 'jadwal_table']);
Route::prefix('/jadwal')->group(function () {
    Route::get('/data', [App\Http\Controllers\JadwalController::class, 'get_data_jadwal']);
    Route::get('/table', [App\Http\Controllers\JadwalController::class, 'jadwal_table']);
});

Route::prefix('/peserta')->group(function () {
    Route::get('/table', [App\Http\Controllers\GetController::class, 'peserta_table']);
});

Route::prefix('/divisi')->group(function () {
    Route::get('/select', [App\Http\Controllers\GetController::class, 'divisi_select']);
});

Route::prefix('/jabatan')->group(function () {
    Route::get('/select', [App\Http\Controllers\GetController::class, 'jabatan_select']);
});

