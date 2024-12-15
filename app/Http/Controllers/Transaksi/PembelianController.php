<?php

namespace App\Http\Controllers\Transaksi;

use Carbon\Carbon;
use App\Models\Jenis;
use App\Models\Produk;
use App\Models\Suplier;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Produk\ProdukController;

class PembelianController extends Controller
{
    protected $produkController;

    public function __construct(ProdukController $produkController)
    {
        $this->produkController = $produkController;
    }

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

    public function getPembelian()
    {
        $pembelian  = Pembelian::with(['suplier', 'jenis', 'pelanggan', 'produk'])->get();
        return response()->json(['success' => true, 'message' => 'Data Pembelian Berhasil Ditemukan', 'Data' => $pembelian]);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'integer'  => ':attribute format wajib menggunakan angka',
            'mimes'    => ':attribute format wajib menggunakan PNG/JPG'
        ];

        $credentials = $request->validate([
            'nama'          =>  'required',
            'jenis_id'      =>  'required|' . Rule::in(Jenis::where('status', 1)->pluck('id')),
            'harga_beli'    =>  'integer',
            'keterangan'    =>  'string',
            'berat'         =>  [
                'required',
                'regex:/^\d+\.\d{1}$/'
            ],
            'karat'         =>  'required|integer',
            'status'        =>  'required'
        ], $messages);


        if ($request->suplier_id != "" || $request->pelanggan_id == "") {
            $request['pelanggan_id'] = null;
        } elseif ($request->suplier_id == '' || $request->pelanggan_id != "") {
            $request['suplier_id'] = null;
        }

        $request['kodepembelian']   = $this->generateCodeTransaksi();
        $request['kodeproduk']      = $this->produkController->generateKode();
        $request['tanggal']         = Carbon::today()->format('Y-m-d');

        $content = QrCode::format('png')->size(300)->generate($request['kodeproduk']); // Ini menghasilkan data PNG sebagai string

        // Tentukan nama file
        $fileName = 'barcode/' . $request['kodeproduk'] . '.png';

        // Simpan file ke dalam storage/public/barcode/
        Storage::put($fileName, $content);

        $createProduk = Produk::create([
            'kodeproduk'    => $request['kodeproduk'],
            'jenis_id'      => $request->jenis_id,
            'nama'          => $request->nama,
            'harga_jual'    => 0,
            'harga_beli'    => $request->harga_beli,
            'keterangan'    => $request->keterangan,
            'berat'         => $request->berat,
            'karat'         => $request->karat,
            'status'        => 2
        ]);

        if ($createProduk) {
            Pembelian::create([
                'kodepembelian' => $request['kodepembelian'],
                'suplier_id'    => $request['suplier_id'],
                'pelanggan_id'  => $request['pelanggan_id'],
                'kodeproduk'    => $request['kodeproduk'],
                'kondisi'       => $request['kondisi'],
                'tanggal'       => $request['tanggal'],
                'status'        => $request['status']
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Data Pembelian Berhasil Disimpan']);
    }

    public function show($id)
    {
        $pembelian = Pembelian::where('id', $id)->with(['pelanggan', 'suplier', 'produk.jenis'])->get();
        return response()->json(['success' => true, 'message' => 'Data Pembelian Berhasil Ditemukan', 'Data' => $pembelian]);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'integer'  => ':attribute format wajib menggunakan angka',
            'mimes'    => ':attribute format wajib menggunakan PNG/JPG'
        ];

        $credentials = $request->validate([
            'nama'          =>  'required',
            'jenis_id'      =>  'required|' . Rule::in(Jenis::where('status', 1)->pluck('id')),
            'harga_beli'    =>  'integer',
            'keterangan'    =>  'string',
            'berat'         =>  [
                'required',
                'regex:/^\d+\.\d{1}$/'
            ],
            'karat'         =>  'required|integer',
            'status'        =>  'required'
        ], $messages);

        $kodeproduk = Pembelian::where('id', $id)->first()->kodeproduk;

        $pembelian = Pembelian::findOrFail($id);

        $request['suplier_id'] = $request->input('suplier_id') ?: NULL;
        $request['pelanggan_id'] = $request->input('pelanggan_id') ?: NULL;

        $pembelian->update($request->all());

        if ($pembelian) {
            Produk::where('kodeproduk', $kodeproduk)
                ->update([
                    'jenis_id'      => $request->jenis_id,
                    'nama'          => $request->nama,
                    'harga_jual'    => 0,
                    'harga_beli'    => $request->harga_beli,
                    'keterangan'    => $request->keterangan,
                    'berat'         => $request->berat,
                    'karat'         => $request->karat,
                    'status'        => 2
                ]);
        }

        return response()->json(['success' => true, 'message' => 'Data Pembelian Berhasil Disimpan', 'data' => $request]);
    }

    public function confirmPaymentPembelian($id)
    {
        $pembelian  = Pembelian::where('id', $id)
            ->update([
                'status' => 2,
            ]);

        return response()->json(['success' => true, 'message' => 'Pembayaran Di Konfirmasi']);
    }

    public function cancelPaymentPembelian($id)
    {
        $kodeproduk = Pembelian::where('id', $id)->first()->kodeproduk;

        $pembelian  = Pembelian::where('id', $id)
            ->update([
                'status' => 0,
            ]);

        if ($pembelian) {
            Produk::where('kodeproduk', $kodeproduk)
                ->update([
                    'status' => 0,
                ]);
        }

        return response()->json(['success' => true, 'message' => 'Pembayaran Di Konfirmasi']);
    }

    public function detailPembelian($id)
    {
        return view('pages.detail-pembelian');
    }
}
