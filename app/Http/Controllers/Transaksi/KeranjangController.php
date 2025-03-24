<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    private function generateCodeKeranjang()
    {
        // Cek apakah ada kode keranjang terakhir dengan status 1
        $lastKeranjangWithStatusOne = DB::table('keranjang')
            ->where('status', 1)
            ->orderBy('kodekeranjang', 'desc')
            ->first();

        // Jika ada kode keranjang dengan status 1, gunakan kode itu
        if ($lastKeranjangWithStatusOne) {
            return $lastKeranjangWithStatusOne->kodekeranjang;
        }

        // Jika tidak ada keranjang dengan status 1, ambil kode keranjang terakhir secara umum
        $lastKeranjang = DB::table('keranjang')
            ->orderBy('kodekeranjang', 'desc')
            ->first();

        // Jika tidak ada keranjang sama sekali, mulai dari 1
        $lastNumber = $lastKeranjang ? (int) substr($lastKeranjang->kodekeranjang, -5) : 0;

        // Tambahkan 1 pada nomor terakhir
        $newNumber = $lastNumber + 1;

        // Format kode keranjang baru
        $newKodeKeranjang = '#K-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKodeKeranjang;
    }

    public function index()
    {
        $keranjang = Keranjang::where('status', 1)
            ->where('user_id', Auth::user()->id)
            ->with(['produk', 'user'])
            ->get()
            ->map(function ($item) {
                if ($item->produk) {
                    // Format berat dengan 4 angka di belakang koma
                    $item->produk->berat = number_format((float) $item->produk->berat, 4, '.', '');

                    // Hitung harga total
                    $item->produk->hargatotal = number_format((float) $item->produk->harga_jual * (float) $item->produk->berat, 2, '.', '');
                }
                return $item;
            });

        return response()->json(['success' => true, 'message' => 'Produk Keranjang Berhasil Ditemukan', 'data' => $keranjang]);
    }

    private function cekItem($id)
    {
        return DB::table('keranjang')
            ->where('produk_id', $id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function getCount()
    {
        $count = Keranjang::where('status', 1)->where('user_id', Auth::user()->id)->count();

        return response()->json(['success' => true, 'count' => $count]);
    }

    public function addtocart(Request $request, $id)
    {
        //GENERATE CODE KERANJANG
        $generateCode = $this->generateCodeKeranjang();

        // Memanggil cekItem untuk memeriksa apakah item dengan status 1 sudah ada
        $existingItem = $this->cekItem($id);

        if ($existingItem && $existingItem->status == 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk sudah ada di keranjang'
            ]);
        }

        //HargaBarang
        $harga  = Produk::where('id', $id)->first()->harga_jual;
        $berat  = Produk::where('id', $id)->first()->berat;
        $total  = $harga * $berat;

        $request['kodekeranjang']   = $generateCode;
        $request['produk_id']       = $id;
        $request['harga']           = $harga;
        $request['total']           = $total;
        $request['user_id']         = Auth::user()->id;
        $request['status']          = 1;

        $keranjang = Keranjang::create($request->all());

        return response()->json(['success' => true, 'message' => 'Produk Berhasil Ditambahkan', 'data' => $keranjang]);
    }

    public function deleteKeranjang($id)
    {
        $keranjang = Keranjang::where('id', $id)
            ->update([
                'status' => 0
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus',
        ]);
    }

    public function deleteKeranjangAll()
    {
        $keranjang = Keranjang::where('status', 1)
            ->where('user_id', Auth::user()->id)
            ->update([
                'status'    =>  0
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua Produk berhasil dihapus',
            'data' => $keranjang
        ]);
    }

    public function totalHargaKeranjang()
    {
        $total = Keranjang::with('produk')
            ->where('status', 1)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->sum(function ($item) {
                return $item->total;
            });

        return response()->json(['success' => true, 'total' => $total]);
    }
}
