<?php

namespace App\Http\Controllers\Perbaikan;

use App\Http\Controllers\Controller;
use App\Models\Perbaikan;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    public function index()
    {
        return view('pages.perbaikan');
    }

    public function getPerbaikan()
    {
        $perbaikan = Perbaikan::with([
            'produk',
            'user.pegawai'
        ])->where('status', '!=', 0)->get();

        return response()->json(['success' => true, 'message' => 'Data Perbaikan Berhasil Ditemukan', 'Data' => $perbaikan]);
    }

    public function getProdukKusam()
    {
        $produkKusam = Perbaikan::where('status', '!=', 0)
            ->where('kondisi_id', 2)
            ->with(['produk', 'user.pegawai'])->get();

        return response()->json(['success' => true, 'message' => 'Data Produk Kusam Berhasil Ditemukan', 'Data' => $produkKusam]);
    }

    public function getProdukRusak()
    {
        $produkRusak = Perbaikan::where('status', '!=', 0)
            ->where('kondisi_id', 3)
            ->with(['produk', 'user.pegawai'])->get();

        return response()->json(['success' => true, 'message' => 'Data Produk Rusak Berhasil Ditemukan', 'Data' => $produkRusak]);
    }
}
