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
        $order = Transaksi::with(['keranjang', 'pelanggan', 'user'])->get();
        return view('pages.order', ['order' => $order]);
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

        $kodekeranjang  = Transaksi::where('id', $id)->first()->kodekeranjang;
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
}
