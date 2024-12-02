<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Jenis;
use App\Models\Suplier;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $pembelian  = Pembelian::with(['suplier', 'jenis', 'pelanggan'])->get();
        $jenis      = Jenis::all();
        $suplier    = Suplier::where('status', 1)->get();
        $pelanggan  = Pelanggan::where('status', 1)->get();
        return view('pages.pembelian', [
            'pembelian' =>  $pembelian,
            'jenis'     =>  $jenis,
            'suplier'   =>  $suplier,
            'pelanggan' =>  $pelanggan
        ]);
    }

    public function store(Request $request)
    {
        if ($request->suplier_id != "Pilih Suplier" || $request->pelanggan_id == "Pilih Pelanggan") {
            $request['pelanggan_id'] = null;
        } elseif ($request->suplier_id == 'Pilih Suplier' || $request->pelanggan_id != "Pilih Pelanggan") {
            $request['suplier_id'] = null;
        }

        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'integer'  => ':attribute format wajib menggunakan angka',
            'mimes'    => ':attribute format wajib menggunakan PNG/JPG'
        ];

        $credentials = $request->validate([
            'nama'          =>  'required',
            'jenis_id'      =>  'required|' . Rule::in(Jenis::where('status', 1)->pluck('id')),
            'harga_jual'    =>  'integer',
            'harga_beli'    =>  'integer',
            'keterangan'    =>  'string',
            'berat'         =>  [
                'required',
                'regex:/^\d+\.\d{1}$/'
            ],
            'karat'         =>  'required|integer',
            'status'        =>  'required'
        ], $messages);

        return response()->json($request);
    }
}
