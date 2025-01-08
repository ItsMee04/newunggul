<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Pegawai\JabatanController;
use App\Http\Controllers\Pegawai\UserController;
use App\Http\Controllers\Produk\JenisController;
use App\Http\Controllers\Produk\NampanController;
use App\Http\Controllers\Produk\ProdukController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Transaksi\POSController;
use App\Http\Controllers\Pegawai\PegawaiController;
use App\Http\Controllers\Transaksi\OrderController;
use App\Http\Controllers\Transaksi\DiskonController;
use App\Http\Controllers\Pelanggan\SuplierController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\Perbaikan\PerbaikanController;
use App\Http\Controllers\Produk\KondisiController;
use App\Http\Controllers\Transaksi\KeranjangController;
use App\Http\Controllers\Transaksi\PembelianController;

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
    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('jabatan', [JabatanController::class, 'index']);

    Route::get('pegawai', [PegawaiController::class, 'index']);
    Route::get('pegawai/getpegawai', [PegawaiController::class, 'getPegawai']);
    Route::get('pegawai/{id}', [PegawaiController::class, 'show']);
    Route::post('pegawai', [PegawaiController::class, 'store']);
    Route::post('pegawai/{id}', [PegawaiController::class, 'update']);
    Route::delete('pegawai/{id}', [PegawaiController::class, 'delete']);

    Route::get('user', [UserController::class, 'index']);
    Route::get('user/getUser', [UserController::class, 'getUser']);
    Route::get('user/{id}', [UserController::class, 'show']);
    Route::post('user/{id}', [UserController::class, 'update']);

    Route::get('jenis', [JenisController::class, 'index']);
    Route::get('jenis/getJenis', [JenisController::class, 'getJenis']);
    Route::get('jenis/{id}', [JenisController::class, 'show']);
    Route::post('jenis', [JenisController::class, 'store']);
    Route::post('jenis/{id}', [JenisController::class, 'update']);
    Route::delete('jenis/{id}', [JenisController::class, 'delete']);

    Route::get('produk', [ProdukController::class, 'index']);
    Route::get('produk/getProduk', [ProdukController::class, 'getProduk']);
    Route::post('produk', [ProdukController::class, 'store']);
    Route::get('produk/{id}', [ProdukController::class, 'show']);
    Route::post('produk/{id}', [ProdukController::class, 'update']);
    Route::delete('produk/{id}', [ProdukController::class, 'delete']);
    Route::get('downloadBarcode/{id}', [ProdukController::class, 'downloadBarcode']);
    Route::get('streamBarcode/{id}', [ProdukController::class, 'streamBarcode']);

    Route::get('nampan', [NampanController::class, 'index']);
    Route::get('nampan/getNampan', [NampanController::class, 'getNampan']);
    Route::post('nampan', [NampanController::class, 'store']);
    Route::get('nampan/{id}', [NampanController::class, 'show']);
    route::get('nampan/getNampanProduk/{id}', [NampanController::class, 'getNampanProduk']);
    route::get('nampan/getProdukNampan/{id}', [NampanController::class, 'getProdukNampan']);
    Route::get('nampan/getNampanByID/{id}', [NampanController::class, 'getNampanByID']);
    Route::post('update-nampan/{id}', [NampanController::class, 'update']);
    Route::delete('delete-nampan/{id}', [NampanController::class, 'delete']);
    Route::post('produk-nampan/{id}', [NampanController::class, 'nampanStore']);
    Route::delete('delete-nampan-produk/{id}', [NampanController::class, 'nampanDelete']);

    Route::get('scan', [ProdukController::class, 'scanner']);
    Route::get('scan/{id}', [ProdukController::class, 'scandetail']);
    Route::post('scanqr', [ProdukController::class, 'scanqr']);

    Route::get('pelanggan', [PelangganController::class, 'index']);
    Route::get('pelanggan/getPelanggan', [PelangganController::class, 'getPelanggan']);
    Route::post('pelanggan', [PelangganController::class, 'store']);
    Route::get('pelanggan/{id}', [PelangganController::class, 'show']);
    Route::post('pelanggan/{id}', [PelangganController::class, 'update']);
    Route::delete('pelanggan/{id}', [PelangganController::class, 'delete']);

    Route::get('suplier', [SuplierController::class, 'index']);
    Route::get('suplier/getSuplier', [SuplierController::class, 'getSuplier']);
    Route::post('suplier', [SuplierController::class, 'store']);
    Route::get('suplier/{id}', [SuplierController::class, 'show']);
    Route::post('suplier/{id}', [SuplierController::class, 'update']);
    Route::delete('suplier/{id}', [SuplierController::class, 'delete']);

    Route::get('diskon', [DiskonController::class, 'index']);
    Route::get('diskon/getDiskon', [DiskonController::class, 'getDiskon']);
    Route::get('diskon/{id}', [DiskonController::class, 'show']);
    Route::post('diskon', [DiskonController::class, 'store']);
    Route::post('diskon/{id}', [DiskonController::class, 'update']);
    Route::delete('diskon/{id}', [DiskonController::class, 'delete']);

    Route::get('pos', [POSController::class, 'index']);
    Route::get('pos/{id}', [POSController::class, 'getItem']);
    Route::get('pos/fetchAllItem', [POSController::class, 'fetchAllItem']);
    Route::get('getKodeKeranjang', [POSController::class, 'getKodeKeranjang']);
    Route::get('generateCodeTransaksi', [POSController::class, 'getKodeTransaksi']);

    Route::post('addtocart/{id}', [KeranjangController::class, 'addtocart']);
    Route::get('getKeranjang', [KeranjangController::class, 'index']);
    Route::get('getCount', [KeranjangController::class, 'getCount']);
    Route::delete('deleteKeranjangItem/{id}', [KeranjangController::class, 'deleteKeranjang']);
    Route::delete('deleteKeranjangAll', [KeranjangController::class, 'deleteKeranjangAll']);
    Route::get('totalHargaKeranjang', [KeranjangController::class, 'totalHargaKeranjang']);

    Route::post('payment', [POSController::class, 'payment']);

    Route::get('order', [OrderController::class, 'index']);
    Route::get('order/getOrder', [OrderController::class, 'getOrder']);
    Route::get('confirmPayment/{id}', [OrderController::class, 'confirmPayment']);
    Route::get('cancelPayment/{id}', [OrderController::class, 'cancelPayment']);
    Route::get('order/{id}', [OrderController::class, 'detailOrder']);

    Route::get('kondisi/getKondisi', [KondisiController::class, 'getKondisi']);

    Route::get('pembelian', [PembelianController::class, 'index']);
    Route::get('pembelian/getPembelian', [PembelianController::class, 'getPembelian']);
    Route::post('pembelian', [PembelianController::class, 'store']);
    Route::get('pembelian/{id}', [PembelianController::class, 'show']);
    Route::post('pembelian/{id}', [PembelianController::class, 'update']);
    Route::get('pembelian/confirmPayment/{id}', [PembelianController::class, 'confirmPaymentPembelian']);
    Route::get('pembelian/cancelPayment/{id}', [PembelianController::class, 'cancelPaymentPembelian']);
    Route::get('pembelian/detailPembelian/{id}', [PembelianController::class, 'detailpembelian']);
    Route::get('getPembelianProduk', [PembelianController::class, 'getPembelianProduk']);
    Route::post('insertProdukPembelian', [PembelianController::class, 'insertProdukPembelian']);
    Route::get('deleteProdukPembelian/{id}', [PembelianController::class, 'deleteProdukPembelian']);
    Route::get('getKodePembelianProduk', [PembelianController::class, 'getKodePembelianProduk']);

    Route::get('perbaikan', [PerbaikanController::class, 'index']);
    Route::get('perbaikan/getPerbaikan', [PerbaikanController::class, 'getPerbaikan']);

    Route::get('order/cetakNotaTransaksi/{id}', [ReportController::class, 'cetakNotaTransaksi']);

    Route::get('logout', [AuthController::class, 'logout']);
});
