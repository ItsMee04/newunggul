<?php

namespace App\Http\Controllers\Stok;

use Carbon\Carbon;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\NampanProduk;
use PhpParser\Node\Expr\FuncCall;

class StokController extends Controller
{
    private function generateCodeStok()
    {
        // Ambil kode customer terakhir dari database
        $lastCustomer = DB::table('stok')
            ->orderBy('kodetransaksi', 'desc')
            ->first();

        // Jika tidak ada customer, mulai dari 1
        $lastNumber = $lastCustomer ? (int) substr($lastCustomer->kodetransaksi, -5) : 0;

        // Tambahkan 1 pada nomor terakhir
        $newNumber = $lastNumber + 1;

        // Format kode customer baru
        $newKodeCustomer = '#STK-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKodeCustomer;
    }

    public function index()
    {
        return view('pages.stok');
    }

    public function getStokByNampan()
    {
        $stok = Stok::with(['nampan'])->where('status', 1)->get();
        return response()->json(['success' => true, 'message' => 'Data Stok Berhasil Ditemukan', 'Data' => $stok]);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
        ];

        $credentials = $request->validate([
            'nampan'   =>  'required'
        ], $messages);

        $kodetransaksi = $this->generateCodeStok();

        $stok = Stok::create([
            'kodetransaksi' =>  $kodetransaksi,
            'nampan_id'     =>  $request->nampan,
            'tanggal'       =>  Carbon::today()->format('Y-m-d'),
            'keterangan'    =>  $request->keterangan,
            'status'        =>  1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data Berhasil Ditambahkan', 'Data' => $stok]);
    }

    public function show($id)
    {
        $stok = Stok::with(['nampan'])->find($id);

        return response()->json(['success' => true, 'message' => 'Data Berhasil Ditemukan', 'Data' => $stok]);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
        ];

        $credentials = $request->validate([
            'nampan'   =>  'required',
            'keterangan'    => 'required'
        ], $messages);

        $stok = Stok::where('id', $id)
            ->update([
                'nampan_id'     =>  $request->nampan,
                'keterangan'    => $request->keterangan,
                'tanggal'       =>  Carbon::today()->format('Y-m-d'),
            ]);

        return response()->json(['success' => true, 'message' => 'Data Berhasil Diubah']);
    }

    public function delete($id)
    {
        $stok = Stok::find($id);

        $stok->delete();

        return response()->json(['success' => true, 'message' => 'Data Stok Berhasil Dihapus']);
    }

    public function detailProduk($id)
    {
        return view('pages.stok-detail');
    }

    public function getProdukByNampanID($id)
    {
        $produk = NampanProduk::with(['produk.jenis', 'nampan.jenis'])->where('nampan_id', $id)->get();

        $totalBerat = $produk->sum(function ($item) {
            return (float) $item->produk->berat;
        });

        return response()->json([
            'success' => true,
            'message' => 'Data Produk Berhasil Ditemukan',
            'total_berat' => $totalBerat,
            'Data' => $produk
        ]);
    }
}
