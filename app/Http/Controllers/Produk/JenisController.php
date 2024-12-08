<?php

namespace App\Http\Controllers\Produk;

use App\Models\Jenis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
        return view('pages.jenis', ['jenis' => $jenis]);
    }

    public function getJenis()
    {
        $jenis = Jenis::all();
        $count = Jenis::count();
        return response()->json(['success' => true, 'message' => 'Data Jenis Ditemukan', 'Data' => $jenis, 'Total' => $count]);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'mimes'    => ':attribute format wajib menggunakan PNG/JPG'
        ];

        $credentials = $request->validate([
            'jenis'         => 'required',
            'icon'          => 'mimes:png,jpg,jpeg',
            'status'        => 'required',
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('jenis')->with('errors-message', 'Status wajib di isi !!!');
        }

        $icon = "";
        if ($request->file('icon')) {
            $extension = $request->file('icon')->getClientOriginalExtension();
            $icon = $request->jenis . '.' . $extension;
            $request->file('icon')->storeAs('Icon', $icon);
            $request['icon'] = $icon;
        }

        $jenis = Jenis::create([
            'jenis'  => $request->jenis,
            'icon'   => $icon,
            'status' => $request->status
        ]);

        return response()->json(['success' => true, 'message' => "Data Jenis Berhasil Disimpan", 'Data' => $jenis]);
    }

    public function show($id)
    {
        $jenis = Jenis::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data Jenis Berhasil Ditemukan', 'data' => $jenis]);
    }

    public function update(Request $request, $id)
    {
        $jenis = Jenis::where('id', $id)->first();

        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'mimes'    => ':attribute format wajib menggunakan PNG/JPG'
        ];

        $credentials = $request->validate([
            'jenis'         => 'required',
            'icon'          => 'mimes:png,jpg,jpeg',
            'status'        => 'required',
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('jenis')->with('errors-message', 'Status wajib di isi !!!');
        }

        if ($request->file('icon')) {

            $path = 'storage/Icon/' . $jenis->icon;

            if (File::exists($path)) {
                File::delete($path);
            }

            $extension = $request->file('icon')->getClientOriginalExtension();
            $newphoto = $request->jenis . '.' . $extension;
            $request->file('icon')->storeAs('Icon', $newphoto);
            $request['icon'] = $newphoto;

            Jenis::where('id', $id)
                ->update([
                    'jenis'  => $request->jenis,
                    'icon'  => $newphoto,
                    'status' => $request->status
                ]);
        } else {
            Jenis::where('id', $id)
                ->update([
                    'jenis'  => $request->jenis,
                    'status' => $request->status
                ]);
        }

        return response()->json(['success' => true, 'message' => "Data Jenis Berhasil Disimpan"]);
    }

    public function delete($id)
    {
        Jenis::where('id', $id)->delete();
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
