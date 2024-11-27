<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pegawai\UserController;
use App\Http\Controllers\Produk\JenisController;
use App\Http\Controllers\Produk\NampanController;
use App\Http\Controllers\Produk\ProdukController;
use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Controllers\Pelanggan\SuplierController;
use App\Http\Controllers\Pelanggan\PelangganController;

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
    Route::post('produk/{id}', [ProdukController::class, 'update']);
    Route::delete('produk/{id}', [ProdukController::class, 'delete']);
    Route::get('downloadBarcode/{id}', [ProdukController::class, 'downloadBarcode']);
    Route::get('streamBarcode/{id}', [ProdukController::class, 'streamBarcode']);

    Route::get('nampan', [NampanController::class, 'index']);
    Route::post('nampan', [NampanController::class, 'store']);
    Route::get('nampan/{id}', [NampanController::class, 'show']);
    Route::post('update-nampan/{id}', [NampanController::class, 'update']);
    Route::delete('delete-nampan/{id}', [NampanController::class, 'delete']);
    Route::post('produk-nampan/{id}', [NampanController::class, 'nampanStore']);
    Route::delete('delete-nampan-produk/{id}', [NampanController::class, 'nampanDelete']);

    Route::get('scan', [ProdukController::class, 'scanner']);
    Route::get('scan/{id}', [ProdukController::class, 'scandetail']);
    Route::post('scanqr', [ProdukController::class, 'scanqr']);

    Route::get('pelanggan', [PelangganController::class, 'index']);
    Route::post('pelanggan', [PelangganController::class, 'store']);
    Route::post('pelanggan/{id}', [PelangganController::class, 'update']);
    Route::delete('pelanggan/{id}', [PelangganController::class, 'delete']);

    Route::get('suplier', [SuplierController::class, 'index']);
    Route::post('suplier', [SuplierController::class, 'store']);
    Route::post('suplier/{id}', [SuplierController::class, 'update']);
    Route::delete('suplier/{id}', [SuplierController::class, 'delete']);

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
