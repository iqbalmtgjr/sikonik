<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KlinikController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\JanjitemuController;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//kelola pengguna
Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
Route::put('/pengguna', [PenggunaController::class, 'update'])->name('pengguna.update');
Route::put('/pengguna/klinik', [PenggunaController::class, 'updateKlinik'])->name('pengguna.klinik');
Route::get('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
Route::get('/pengguna/getdata/{id}', [PenggunaController::class, 'getdata'])->name('getdatauser');

//kelola klinik
Route::get('/klinik', [KlinikController::class, 'index'])->name('klinik');
Route::post('/klinik', [KlinikController::class, 'store'])->name('klinik.store');
Route::put('/klinik', [KlinikController::class, 'update'])->name('klinik.update');
Route::get('/klinik/delete/{id}', [KlinikController::class, 'destroy'])->name('klinik.destroy');
Route::get('/klinik/getdata/{id}', [KlinikController::class, 'getdata'])->name('getdataklinik');
Route::get('/klinik/getdata2/{id}', [KlinikController::class, 'getdata2'])->name('getdataklinik2');

//janji temu
Route::get('/janjitemu', [JanjitemuController::class, 'index'])->name('janjitemu');
Route::post('/janjitemu', [JanjitemuController::class, 'store'])->name('janjitemu.store');
Route::put('/janjitemu', [JanjitemuController::class, 'update'])->name('janjitemu.update');
Route::put('/janjitemu/catatan', [JanjitemuController::class, 'updatecatatan'])->name('janjitemu.catatan');
Route::get('/janjitemu/delete/{id}', [JanjitemuController::class, 'destroy'])->name('janjitemu.destroy');
Route::get('/janjitemu/getdata/{id}', [JanjitemuController::class, 'getdata'])->name('getdatajanjitemu');
Route::get('/janjitemu/getdata2/{id}', [JanjitemuController::class, 'getdata2'])->name('getdatajanjitemu2');
