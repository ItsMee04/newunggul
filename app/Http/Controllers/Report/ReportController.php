<?php

namespace App\Http\Controllers\Report;

use App\Models\Produk;
use PHPJasper\PHPJasper;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

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

        return view('reports.nota-transaksi');

        // // Generate PDF dari view
        // $pdf = Pdf::loadView('reports.nota-transaksi', $data)->setPaper('A5', 'landscape');

        // // Nama file diambil dari kode transaksi
        // $filename = 'UnggulKencana' . $transaksi->kodetransaksi . '.pdf';

        // // Stream PDF ke browser
        // return $pdf->stream($filename);

        // // Jika ingin langsung diunduh:
        // // return $pdf->download('nota-transaksi.pdf');
    }

    public function CetakSuratBarang($id)
    {
        $produk = Transaksi::with(['keranjang', 'pelanggan', 'keranjang.produk', 'keranjang.produk.kondisi'])->where('id', $id)->get();

        return response()->json(['success' => true, 'message' => 'Data Produk Berhasil Ditemukan', 'Data' => $produk]);
    }

    public function jasperNotaTransaksi($id)
    {
        // $input = storage_path('app/public/Reports/transaksireport.jasper');
        // $output = storage_path('app/public/Reports/output');
        // $jdbc_dir = base_path('vendor/lavela/phpjasper/bin/jasperstarter/jdbc');

        // // Konfigurasi parameter untuk JasperReports
        // $options = [
        //     'format' => ['pdf'], // Bisa juga 'xls', 'docx'
        //     'locale' => 'en',
        //     'params' => [
        //         'Parameter1' => $id // Parameter yang dikirim ke Jasper
        //     ],
        //     'db_connection' => [
        //         'driver' => 'mysql', // Sesuaikan dengan database yang digunakan
        //         'host' => env('DB_HOST', '127.0.0.1'),
        //         'port' => env('DB_PORT', '3306'),
        //         'database' => env('DB_DATABASE', 'laravel-unggulkencana'),
        //         'username' => env('DB_USERNAME', 'root'),
        //         'password' => env('DB_PASSWORD', 'admin'),
        //         'jdbc_driver' => 'com.mysql.jdbc.Driver',
        //         'jdbc_url' => 'jdbc:mysql://127.0.0.1:3306/laravel-unggulkencana',
        //         'jdbc_dir' => $jdbc_dir
        //     ]
        // ];

        // // Jalankan laporan menggunakan PHPJasper
        // $jasper = new PHPJasper();
        // $jasper->process($input, $output, $options)->execute();

        // // Path file PDF hasil cetak
        // $pdfFile = $output . '.pdf';

        // // Periksa apakah file berhasil dibuat
        // if (file_exists($pdfFile)) {
        //     return response()->download($pdfFile);
        // } else {
        //     return response()->json(['error' => 'Gagal membuat laporan'], 500);
        // }


        require base_path('vendor/autoload.php');

        $input = storage_path('app/public/Reports/transaksireport_fixed.jasper');
        $output = storage_path('app/public/Reports/output');
        $jdbc_dir = base_path('vendor/lavela/phpjasper/bin/jasperstarter/jdbc');

        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [
                'Parameter1' => $id,
            ],
            'db_connection' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'port' => '3306',
                'database' => 'laravel-unggulkencana',
                'username' => 'root',
                'password' => 'admin',
                'jdbc_driver' => 'com.mysql.jdbc.Driver',
                'jdbc_url' => 'jdbc:mysql://127.0.0.1:3306;laravel-unggulkencana=Teste',
                'jdbc_dir' => $jdbc_dir
            ]
        ];

        $jasper = new PHPJasper;

        $jasper->process(
            $input,
            $output,
            $options
        )->execute();
    }
}
