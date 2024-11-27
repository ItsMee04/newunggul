<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Jenis;
use App\Models\Diskon;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class POSController extends Controller
{
    private function generateCodeTransaksi()
    {
        // Cek apakah ada kode keranjang terakhir dengan status 1
        $lastKeranjangWithStatusOne = DB::table('transaksi')
            ->where('status', 1)
            ->orderBy('kodetransaksi', 'desc')
            ->first();

        // Jika ada kode keranjang dengan status 1, gunakan kode itu
        if ($lastKeranjangWithStatusOne) {
            return $lastKeranjangWithStatusOne->kodekeranjang;
        }

        // Jika tidak ada keranjang dengan status 1, ambil kode keranjang terakhir secara umum
        $lastKeranjang = DB::table('transaksi')
            ->orderBy('kodetransaksi', 'desc')
            ->first();

        // Jika tidak ada keranjang sama sekali, mulai dari 1
        $lastNumber = $lastKeranjang ? (int) substr($lastKeranjang->kodekeranjang, -5) : 0;

        // Tambahkan 1 pada nomor terakhir
        $newNumber = $lastNumber + 1;

        // Format kode keranjang baru
        $newKodeKeranjang = '#T-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKodeKeranjang;
    }

    public function index()
    {
        $jenis = Jenis::where('status', 1)->get();
        $produk = Produk::where('status', 1)->get();
        $diskon = Diskon::where('status', 1)->get();
        $pelanggan = Pelanggan::where('status', 1)->get();
        $keranjang = Keranjang::where('status', 1)->where('user_id', Auth::user()->id)->with('produk')->with('user')->get();
        $kodetransaksi = $this->generateCodeTransaksi();

        $jenisProduk = DB::table('produk')
            ->select('jenis_id')
            ->where('status', 1)
            ->groupBy('jenis_id')
            ->get();

        return view('pages.pos', [
            'jenis'         =>  $jenis,
            'produk'        =>  $produk,
            'jenisProduk'   =>  $jenisProduk,
            'pelanggan'     =>  $pelanggan,
            'kodetransaksi' =>  $kodetransaksi,
            'keranjang'     =>  $keranjang,
            'diskon'        =>  $diskon,
        ]);
    }

    public function getItem($id)
    {
        if ($id == 'all') {
            $produk = Produk::with('jenis')->where('status', 1)->get();
            return response()->json([
                'success'   =>  true,
                'message'   =>  "Data Ditemukan",
                "Data"      =>  $produk
            ]);
        } else {
            $produk = Produk::with('jenis')->where('jenis_id', $id)->where('status', 1)->get();

            return response()->json([
                'success'   =>  true,
                'message'   =>  "Data Ditemukan",
                "Data"      =>  $produk->loadMissing('jenis')
            ]);
        }
    }

    public function fetchAllItem()
    {
        $produk = Produk::with('jenis')->where('status', 1)->get();

        foreach ($produk as $item) {
            $item['harga_jual'] = number_format($item['harga_jual'], 0, ',', '.');
        }
        return response()->json([
            'success'   =>  true,
            'message'   =>  "Data Ditemukan",
            'Data'      =>  $produk
        ]);
    }
}
