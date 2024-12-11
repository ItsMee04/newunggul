<?php

namespace App\Http\Controllers\Produk;

use App\Models\Jenis;
use App\Models\Nampan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\NampanProduk;
use App\Models\Produk;

class NampanController extends Controller
{
    public function index()
    {
        $nampan = Nampan::with('jenis')->get();
        $jenis  = Jenis::where('status', 1)->get();
        return view('pages.nampan', ['nampan' => $nampan, 'jenis' => $jenis]);
    }

    public function getNampan()
    {
        $nampan = Nampan::with('jenis')->get();
        return response()->json(['success' => true, 'message' => 'Data Nampan Berhasil Ditemukan', 'Data' => $nampan]);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
        ];

        $credentials = $request->validate([
            'jenis'         => 'required',
            'nampan'        => 'required',
            'status'        => 'required'
        ], $messages);

        if ($request->jenis == 'Pilih Jenis Produk') {
            return redirect('nampan')->with('errors-message', 'Jenis wajib di isi !!!');
        }

        if ($request->status == 'Pilih Status') {
            return redirect('nampan')->with('errors-message', 'Status wajib di isi !!!');
        }

        $storeNampan = Nampan::create([
            'jenis_id'  =>  $request->jenis,
            'nampan'    =>  $request->nampan,
            'status'    =>  $request->status
        ]);

        return response()->json(['success' => true, 'message' => 'Data Nampan Berhasil Disimpan', 'Data' => $storeNampan]);
    }

    public function getNampanByID($id)
    {
        $nampan = Nampan::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data Nampan Berhasil Ditemukan', 'data' => $nampan]);
    }

    public function show($id)
    {
        $nampanProduk = NampanProduk::with(['nampan', 'produk'])->where('nampan_id', $id)->get();
        $nampan       = Nampan::where('id', $id)->first();
        $produk       = Produk::where('jenis_id', $nampan->jenis_id)->get();
        return view('pages.nampan-produk', ['nampanProduk' => $nampanProduk, 'nampan' => $nampan, 'produk' => $produk]);
    }

    public function getNampanProduk($id)
    {
        $nampanProduk = NampanProduk::with(['nampan', 'produk'])->where('nampan_id', $id)->get();
        return response()->json(['success' => true, 'message' => 'Data Nampan Produk Berhasil Ditemukan', 'Data' => $nampanProduk]);
    }

    public function getProdukNampan($id)
    {
        $nampan       = Nampan::where('id', $id)->first();
        $produk       = Produk::where('jenis_id', $nampan->jenis_id)->get();
        return response()->json(['success' => true, 'message' => 'Data Nampan Produk Berhasil Ditemukan', 'Data' => $produk]);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
        ];

        $credentials = $request->validate([
            'jenis'         => 'required',
            'nampan'        => 'required',
            'status'        => 'required'
        ], $messages);

        if ($request->jenis == 'Pilih Jenis Produk') {
            return redirect('nampan')->with('errors-message', 'Jenis wajib di isi !!!');
        }

        if ($request->status == 'Pilih Status') {
            return redirect('nampan')->with('errors-message', 'Status wajib di isi !!!');
        }

        $updateNampan = Nampan::where('id', $id)
            ->update([
                'jenis_id'  =>  $request->jenis,
                'nampan'    =>  $request->nampan,
                'status'    =>  $request->status
            ]);

        return response()->json(['success' => true, 'message' => 'Data Nampan Berhasil Disimpan']);
    }

    public function delete($id)
    {
        $nampan = Nampan::where('id', $id)->delete();
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function nampanStore(Request $request, $id)
    {
        $request->validate([
            'items' => 'required|array',
        ]);

        // Ambil daftar produk_id yang sudah ada di NampanProduk
        $existingProducts = NampanProduk::whereIn('produk_id', $request->items)
            ->pluck('produk_id')
            ->toArray();

        if (!empty($existingProducts)) {
            return redirect('nampan/' . $id)->with('errors-message', 'Beberapa produk sudah ada.');
        }

        // Tambahkan produk yang belum ada
        $nampanProducts = [];
        foreach ($request->items as $item) {
            $nampanProducts[] = NampanProduk::create([
                'nampan_id' => $id,
                'produk_id' => $item,
                'tanggal'   => Carbon::today()->format('Y-m-d'),
                'status'    => 1,
            ]);
        }

        return redirect('nampan/' . $id)->with('success-message', 'Produk berhasil ditambahkan. !');
    }

    public function nampanDelete($id)
    {
        $nampan = NampanProduk::find($id);
        $nampan->delete();
        return response()->json(['success' => true, 'message' => 'Data Pelanggan Berhasil Dihapus']);
    }
}
