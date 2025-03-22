<?php

namespace App\Http\Controllers\Report;

use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function cetakNotaTransaksi($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::with('pelanggan')->where('id', $id)->first();

        if (!$transaksi) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        // Ambil data keranjang berdasarkan kodekeranjang dari transaksi
        $keranjang = Keranjang::where('kodekeranjang', $transaksi->keranjang_id)->where('status', '!=', 0)->get();

        // Hitung subtotal dari total pada keranjang
        $subtotal = Keranjang::where('kodekeranjang', $transaksi->keranjang_id)->where('status', '!=', 0)->sum('total');

        // Data untuk dikirim ke view
        $data = [
            'transaksi' => $transaksi,
            'keranjang' => $keranjang,
            'subtotal'  => $subtotal,
        ];

        // Generate PDF dari view
        $pdf = Pdf::loadView('reports.nota-transaksi', $data)->setPaper('A4', 'landscape');

        // Nama file diambil dari kode transaksi
        $filename = 'UnggulKencana' . $transaksi->kodetransaksi . '.pdf';

        // Stream PDF ke browser
        return $pdf->stream($filename);

        // Jika ingin langsung diunduh:
        // return $pdf->download('nota-transaksi.pdf');
    }
}
