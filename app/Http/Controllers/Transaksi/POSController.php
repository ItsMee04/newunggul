<?php

namespace App\Http\Controllers\Transaksi;

use Carbon\Carbon;
use App\Models\Jenis;
use App\Models\Diskon;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Nampan;
use App\Models\NampanProduk;
use Illuminate\Support\Facades\Auth;

class POSController extends Controller
{
    private function generateCodeTransaksi()
    {
        // Ambil kode customer terakhir dari database
        $lastCustomer = DB::table('transaksi')
            ->orderBy('kodetransaksi', 'desc')
            ->first();

        // Jika tidak ada customer, mulai dari 1
        $lastNumber = $lastCustomer ? (int) substr($lastCustomer->kodetransaksi, -5) : 0;

        // Tambahkan 1 pada nomor terakhir
        $newNumber = $lastNumber + 1;

        // Format kode customer baru
        $newKodeCustomer = '#T-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKodeCustomer;
    }

    public function getKodeTransaksi()
    {
        $kodetransaksi = $this->generateCodeTransaksi();

        return response()->json(['success' => true, 'kodetransaksi' => $kodetransaksi]);
    }

    public function index()
    {
        $nampan = Nampan::with('jenis')->where('status', 1)->get();
        $nampanProduk = NampanProduk::where('status', 1)->get();
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
            'nampan'        =>  $nampan,
            'nampanProduk'  =>  $nampanProduk,
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
            $produk = NampanProduk::with('produk')
                ->where('status', 1)
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
            return response()->json([
                'success'   =>  true,
                'message'   =>  "Data Ditemukan",
                "Data"      =>  $produk
            ]);
        } else {
            $produk = NampanProduk::with('produk')
                ->where('nampan_id', $id)
                ->where('status', 1)
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

            return response()->json([
                'success'   =>  true,
                'message'   =>  "Data Ditemukan",
                "Data"      =>  $produk
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

    public function getKodeKeranjang()
    {
        // Ambil data keranjang pertama dengan status 1 dan user_id pengguna yang sedang login
        $keranjang = Keranjang::where('status', 1)
            ->where('user_id', Auth::user()->id)
            ->first();

        // Cek apakah keranjang ditemukan
        if ($keranjang) {
            // Ambil kode keranjang
            $kodeKeranjang = $keranjang->kodekeranjang;

            // Ambil daftar produk berdasarkan kode keranjang
            $produkID = Keranjang::select('produk_id')
                ->where('kodekeranjang', $kodeKeranjang)
                ->get();

            // Kembalikan response JSON dengan kode keranjang dan produk ID
            return response()->json(['success' => true, 'kode' => $keranjang, 'produk_id' => $produkID]);
        } else {
            // Jika keranjang tidak ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Belum ada barang dalam keranjang'
            ]);
        }
    }


    public function payment(Request $request)
    {
        $produk = $request->produkID;

        $payment = Transaksi::create([
            'kodetransaksi' =>  $request->transaksiID,
            'keranjang_id'  =>  $request->kodeKeranjangID,
            'pelanggan_id'  =>  $request->pelangganID,
            'diskon'        =>  $request->diskonID,
            'tanggal'       =>  Carbon::today()->format('Y-m-d'),
            'total'         =>  $request->total,
            'user_id'       =>  Auth::user()->id,
            'status'        =>  1,
        ]);

        if ($payment) {
            Keranjang::where('status', 1)
                ->where('user_id', Auth::user()->id)
                ->where('kodekeranjang', $request->kodeKeranjangID)
                ->update([
                    'status' => 2,
                ]);

            foreach ($produk as $value) {
                Produk::where('id', $value)
                    ->update([
                        'status' => 2,
                    ]);

                NampanProduk::where('produk_id', $value)
                    ->update([
                        'status'    => 2,
                    ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Transaksi Berhasil']);
    }
}
