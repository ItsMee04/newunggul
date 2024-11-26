<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Controllers\Pegawai\UserController;
use App\Http\Controllers\Produk\JenisController;
use App\Http\Controllers\Produk\ProdukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
})->middleware('ceklogin');

Route::get('login', [AuthController::class, 'index'])->name('login')->middleware('ceklogin');
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('pages.dashboard');
    });

    Route::get('pegawai', [PegawaiController::class, 'index']);
    Route::post('pegawai', [PegawaiController::class, 'store']);
    Route::post('pegawai/{id}', [PegawaiController::class, 'update']);
    Route::delete('pegawai/{id}', [PegawaiController::class, 'delete']);

    Route::get('user', [UserController::class, 'index']);
    Route::post('user/{id}', [UserController::class, 'update']);

    Route::get('jenis', [JenisController::class, 'index']);
    Route::post('jenis', [JenisController::class, 'store']);
    Route::post('jenis/{id}', [JenisController::class, 'update']);
    Route::delete('jenis/{id}', [JenisController::class, 'delete']);

    Route::get('produk', [ProdukController::class, 'index']);
    Route::post('produk', [ProdukController::class, 'store']);

    Route::get('nampan', function () {
        return view('pages.nampan');
    });

    Route::get('scan', function () {
        return view('pages.scan');
    });

    Route::get('pelanggan', function () {
        return view('pages.pelanggan');
    });

    Route::get('suplier', function () {
        return view('pages.suplier');
    });

    Route::get('diskon', function () {
        return view('pages.diskon');
    });

    Route::get('pos', function () {
        return view('pages.pos');
    });

    Route::get('order', function () {
        return view('pages.order');
    });

    Route::get('logout', [AuthController::class, 'logout']);
});
