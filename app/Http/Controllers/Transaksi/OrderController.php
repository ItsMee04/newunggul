<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produk;

class OrderController extends Controller
{
    public function index()
    {

        return view('pages.order');
    }

    public function getOrder()
    {
        $order = Transaksi::with(['keranjang', 'pelanggan', 'user.pegawai'])->get();
        return response()->json(['success' => true, 'message' => 'Data Order Berhasil Ditemukan', 'Data' => $order]);
    }

    public function confirmPayment($id)
    {
        $transaksi  = Transaksi::where('id', $id)
            ->update([
                'status' => 2,
            ]);

        return response()->json(['success' => true, 'message' => 'Pembayaran Di Konfirmasi']);
    }

    public function cancelPayment($id)
    {
        $transaksi = Transaksi::where('id', $id)->get();

        $kodekeranjang  = Transaksi::where('id', $id)->first()->keranjang_id;
        $produk_id      = Keranjang::where('kodekeranjang', $kodekeranjang)->get();

        $produkid      = Keranjang::where('kodekeranjang', $kodekeranjang)->pluck('produk_id');

        $cancelPayment  = Transaksi::where('id', $id)
            ->update([
                'status'    => 0,
            ]);

        if ($cancelPayment) {
            Produk::whereIn('id', $produkid)
                ->update([
                    'status'    => 1,
                ]);

            Keranjang::where('kodekeranjang', $kodekeranjang)
                ->update([
                    'status' => 0,
                ]);
        }

        return response()->json(['success' => true, 'message' => 'Transaksi Dibatalkan']);
    }

    public function detailOrder($id)
    {
        $transaksi      = Transaksi::where('id', $id)->first();

        $keranjang      = Keranjang::where('kodekeranjang', $transaksi->keranjang_id)->where('status', '!=', 0)->get();
        $subtotal       = Keranjang::where('kodekeranjang', $transaksi->keranjang_id)->where('status', '!=', 0)->sum('total');
        return view('pages.order-detail', ['transaksi' => $transaksi, 'keranjang' => $keranjang, 'subtotal' => $subtotal]);
    }
}
