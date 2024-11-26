<?php

namespace App\Http\Controllers\Produk;

use App\Models\Jenis;
use App\Models\Nampan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\NampanProduk;

class NampanController extends Controller
{
    public function index()
    {
        $nampan = Nampan::with('jenis')->get();
        $jenis  = Jenis::where('status', 1)->get();
        return view('pages.nampan', ['nampan' => $nampan, 'jenis' => $jenis]);
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

        return redirect('nampan')->with('success-message', 'Data Success Disimpan !');
    }

    public function show($id)
    {
        $nampanProduk = NampanProduk::with(['nampan', 'produk'])->get();
        $nampan       = Nampan::where('id', $id)->first();
        return view('pages.nampan-produk', ['nampanProduk' => $nampanProduk, 'nampan' => $nampan]);
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

        return redirect('nampan')->with('success-message', 'Data Success Disimpan !');
    }

    public function delete($id)
    {
        $nampan = Nampan::where('id', $id)->delete();
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
