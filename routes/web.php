<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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

    Route::get('pegawai', function () {
        return view('pages.pegawai');
    });

    Route::get('user', function () {
        return view('pages.user');
    });

    Route::get('jenis', function () {
        return view('pages.jenis');
    });

    Route::get('produk', function () {
        return view('pages.produk');
    });

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
});
