<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Suplier;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::all()->count();
        $totalSuplier   = Suplier::all()->count();
        $totalPembelian = Pembelian::all()->count();
        $totalPenjualan = Transaksi::all()->count();

        return view('pages.dashboard', [
            'totalPelanggan'    => $totalPelanggan,
            'totalSuplier'      => $totalSuplier,
            'totalPembelian'    => $totalPembelian,
            'totalPenjualan'    => $totalPenjualan
        ]);
    }
}
