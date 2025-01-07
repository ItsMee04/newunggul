<?php

namespace App\Http\Controllers\Transaksi;

use Carbon\Carbon;
use App\Models\Jenis;
use App\Models\Produk;
use App\Models\Kondisi;
use App\Models\Suplier;
use App\Models\Pelanggan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\PembelianProduk;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

    public function generateKodePembelianProduk()
    {
        // Cek apakah ada kode keranjang terakhir dengan status 1
        $lastKeranjangWithStatusOne = DB::table('pembelian_produk')
            ->where('status', 1)
            ->orderBy('kodepembelianproduk', 'desc')
            ->first();

        // Jika ada kode keranjang dengan status 1, gunakan kode itu
        if ($lastKeranjangWithStatusOne) {
            return $lastKeranjangWithStatusOne->kodepembelianproduk;
        }

        // Jika tidak ada keranjang dengan status 1, ambil kode keranjang terakhir secara umum
        $lastKeranjang = DB::table('pembelian_produk')
            ->orderBy('kodepembelianproduk', 'desc')
            ->first();

        // Jika tidak ada keranjang sama sekali, mulai dari 1
        $lastNumber = $lastKeranjang ? (int) substr($lastKeranjang->kodepembelianproduk, -5) : 0;

        // Tambahkan 1 pada nomor terakhir
        $newNumber = $lastNumber + 1;

        // Format kode keranjang baru
        $newKodeKeranjang = '#PO-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKodeKeranjang;
    }

    public function index()
    {
        $pembelian  = Pembelian::with(['suplier', 'pelanggan'])->get();
        $jenis      = Jenis::all();
        $suplier    = Suplier::where('status', 1)->get();
        $pelanggan  = Pelanggan::where('status', 1)->get();
        return view('pages.pembelian', [
            'pembelian' =>  $pembelian,
            'suplier'   =>  $suplier,
            'pelanggan' =>  $pelanggan
        ]);
    }

    public function getPembelian()
    {
        $pembelian  = Pembelian::with(['suplier', 'pelanggan', 'pembelianproduk.produk'])->get();
        return response()->json(['success' => true, 'message' => 'Data Pembelian Berhasil Ditemukan', 'Data' => $pembelian]);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!'
        ];

        $credentials = $request->validate([
            'status'        =>  'required'
        ], $messages);


        if ($request->suplier_id != "" || $request->pelanggan_id == "") {
            $request['pelanggan_id'] = null;
        } elseif ($request->suplier_id == '' || $request->pelanggan_id != "") {
            $request['suplier_id'] = null;
        } elseif ($request->suplier_id == '' || $request->pelanggan_id == "" || $request->nonsuplierdanpembeli != "") {
            $request['suplier_id'] = null;
            $request['pelanggan_id'] = null;
        }

        $request['kodepembelian']   = $this->generateCodeTransaksi();
        $request['tanggal']         = Carbon::today()->format('Y-m-d');

        $pembelian = Pembelian::create([
            'kodepembelian'         => $request['kodepembelian'],
            'kodepembelianproduk'   => $request->kode,
            'suplier_id'            => $request->suplier_id,
            'pelanggan_id'          => $request->pelanggan_id,
            'nonsuplierdanpembeli'  => $request->nonsuplierdanpembeli,
            'tanggal'               => $request['tanggal'],
            'status'                => $request->status
        ]);

        if ($pembelian) {
            PembelianProduk::where('kodepembelianproduk', $request->kode)
                ->update([
                    'status' => 2,
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
        $pembelian = Pembelian::where('id', $id)->with(['pembelianproduk', 'pembelianproduk.produk', 'suplier', 'pelanggan', 'pembelianproduk.user.pegawai'])->first();
        $produk    = Pembelian::where('id', $id)->with(['pembelianproduk', 'pembelianproduk.produk', 'suplier', 'pelanggan', 'pembelianproduk.user.pegawai'])->get();
        return view('pages.pembelian-detail', ['pembelian' => $pembelian, 'produk' => $produk]);
        // return response()->json(["success" => true, 'message' => 'Data Pembelian Berhasil Ditemukan', 'Data' => $pembelian]);
    }

    public function getPembelianProduk()
    {
        $pembelian  = PembelianProduk::where('user_id', Auth::user()->id)->where('status', 1)->with(['produk', 'kondisi', 'user.pegawai'])->get();
        return response()->json(['success' => true, 'message' => 'Data Pembelian Berhasil Ditemukan', 'Data' => $pembelian]);
    }

    public function insertProdukPembelian(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'integer'  => ':attribute format wajib menggunakan angka',
            'mimes'    => ':attribute format wajib menggunakan PNG/JPG'
        ];

        $credentials = $request->validate([
            'nama'                  =>  'required',
            'berat'                 =>  [
                'required',
                'regex:/^\d+\.\d{1}$/'
            ],
            'karat'                 =>  'required|integer',
            'jenis_id'              =>  'required|' . Rule::in(Jenis::where('status', 1)->pluck('id')),
            'hargabeli'             =>  'integer',
            'kondisi_id'            =>  'required|' . Rule::in(Kondisi::where('status', 1)->pluck('id')),
            'keterangan'            =>  'required',
        ], $messages);


        $request['kodepembelianproduk']   = $this->generateKodePembelianProduk();
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
            'harga_beli'    => $request->hargabeli,
            'keterangan'    => $request->keterangan,
            'berat'         => $request->berat,
            'karat'         => $request->karat,
            'kondisi_id'    => $request->kondisi_id,
            'status'        => 2
        ]);

        if ($createProduk) {
            $berat  = $request->berat;
            $harga  = $request->hargabeli;

            $total  = $berat * $harga;

            PembelianProduk::create([
                'kodepembelianproduk'   =>  $request['kodepembelianproduk'],
                'kodeproduk'            =>  $request['kodeproduk'],
                'harga'                 =>  $request->hargabeli,
                'total'                 =>  $total,
                'kondisi_id'            =>  $request->kondisi_id,
                'user_id'               =>  Auth::user()->id,
                'status'                =>  1,
            ]);


            return response()->json(['success' => true, 'message' => 'Data Produk Berhasil Ditambahkan']);
        }
    }

    public function deleteProdukPembelian($id)
    {
        $pembelianproduk = PembelianProduk::where('id', $id)
            ->update([
                'status' => 0
            ]);

        if ($pembelianproduk) {
            $kodeproduk = PembelianProduk::where('id', $id)->first()->kodeproduk;
            Produk::where('kodeproduk', $kodeproduk)
                ->update([
                    'status'    =>  0,
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus',
        ]);
    }

    public function getKodePembelianProduk()
    {
        // Ambil data keranjang pertama dengan status 1 dan user_id pengguna yang sedang login
        $PembelianProduk = PembelianProduk::where('status', 1)
            ->where('user_id', Auth::user()->id)
            ->first();

        // Cek apakah keranjang ditemukan
        if ($PembelianProduk) {
            // Ambil kode keranjang
            $kodeKeranjang = $PembelianProduk->kodepembelianproduk;

            // Ambil daftar produk berdasarkan kode keranjang
            $produkID = PembelianProduk::select('kodeproduk')
                ->where('kodepembelianproduk', $kodeKeranjang)
                ->get();

            // Kembalikan response JSON dengan kode keranjang dan produk ID
            return response()->json(['success' => true, 'kode' => $kodeKeranjang, 'kodeproduk' => $produkID]);
        } else {
            // Jika keranjang tidak ditemukan
            return response()->json([
                'success' => false,
                'message' => 'Belum ada produk dalam pembelian'
            ]);
        }
    }
}
