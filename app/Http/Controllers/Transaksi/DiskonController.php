<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Diskon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiskonController extends Controller
{
    public function index()
    {
        $diskon = Diskon::all();
        return view('pages.diskon', ['diskon' => $diskon]);
    }

    public function store(Request $request)
    {
        $messages = [
            'required'  => ':attribute wajib di isi !!!',
            'integer'   => ':attribute format wajib menggunakan angka',
            'numeric'   => ':attribute format wajib menggunakan angka',
        ];

        $credentials = $request->validate([
            'nama'            => 'required',
            'diskon'          => 'required|integer|numeric',
            'status'          => 'required',
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('diskon')->with('errors-message', 'Status wajib di isi !!!');
        }

        $diskon = Diskon::create($request->all());

        return redirect('diskon')->with('success-message', 'Data Promo Berhasil Disimpan');
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required'  => ':attribute wajib di isi !!!',
            'integer'   => ':attribute format wajib menggunakan angka',
            'numeric'   => ':attribute format wajib menggunakan angka',
        ];

        $credentials = $request->validate([
            'nama'            => 'required',
            'diskon'          => 'required|integer|numeric',
            'status'          => 'required',
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('diskon')->with('errors-message', 'Status wajib di isi !!!');
        }

        $diskon = Diskon::findOrFail($id);

        $diskon->update($request->all());

        return redirect('diskon')->with('success-message', 'Data Promo Berhasil Disimpan');
    }

    public function delete($id)
    {
        $diskon = Diskon::find($id);

        $diskon->delete();

        return response()->json(['success' => true, 'message' => 'Data Promo Berhasil Dihapus']);
    }
}
