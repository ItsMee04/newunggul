<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    private function generateCodeTransaksi()
    {
        // Ambil kode customer terakhir dari database
        $lastCustomer = DB::table('pembelian')
            ->orderBy('kodepembelian', 'desc')
            ->first();

        // Jika tidak ada customer, mulai dari 1
        $lastNumber = $lastCustomer ? (int) substr($lastCustomer->kodepembelian, -5) : 0;

        // Tambahkan 1 pada nomor terakhir
        $newNumber = $lastNumber + 1;

        // Format kode customer baru
        $newKodeCustomer = '#P-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKodeCustomer;
    }

    public function index()
    {
        $pembelian = Pembelian::with(['suplier', 'jenis', 'pelanggan'])->get();
        return view('pages.pembelian', ['pembelian' => $pembelian]);
    }

    public function store(Request $request) {}
}
