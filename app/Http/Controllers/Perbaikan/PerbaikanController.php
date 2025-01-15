<?php

namespace App\Http\Controllers\Perbaikan;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function updatePerbaikanProduk($id)
    {
        $produkid = Perbaikan::where('id', $id)->first()->produk_id;

        $perbaikan = Perbaikan::where('id', $id)
            ->update([
                'tanggal_keluar'    =>  Carbon::today()->format('Y-m-d'),
            ]);

        if ($perbaikan) {
            $produk = Produk::where('id', $produkid)
                ->update([
                    'kondisi_id'        =>  1,
                    'status'            =>  1,
                ]);

            if ($produk) {
                $dataproduk = Produk::where('id', $id)->get();
            }
        }

        return response()->json(['success' => true, 'message' => 'Data Berhasil Diupdate', 'Data' => $dataproduk]);
    }
}
