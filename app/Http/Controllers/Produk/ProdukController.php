<?php

namespace App\Http\Controllers\Produk;

use App\Models\Jenis;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProdukController extends Controller
{
    public function generateKode()
    {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomCode = '';

        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomCode;
    }

    public function index()
    {
        $produk = Produk::with('jenis')->get();
        $jenis  = Jenis::where('status', 1)->get();
        return view('pages.produk', ['produk' => $produk, 'jenis' => $jenis]);
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
            'harga_jual'    =>  'integer',
            'harga_beli'    =>  'integer',
            'keterangan'    =>  'string',
            'berat'         =>  [
                'required',
                'regex:/^\d+\.\d{1}$/'
            ],
            'karat'         =>  'required|integer',
            'image_file'    =>  'nullable|mimes:png,jpg',
            'status'        =>  'required'
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('produk')->with('errors-message', 'Status wajib di isi !!!');
        }

        if ($request->jenis == 'Pilih Jenis') {
            return redirect('produk')->with('errors-message', 'Status Jenis di isi !!!');
        }

        $kodeproduk = $this->generateKode();

        $content = QrCode::format('png')->size(300)->generate($kodeproduk); // Ini menghasilkan data PNG sebagai string

        // Tentukan nama file
        $fileName = 'barcode/' . $kodeproduk . '.png';

        // Simpan file ke dalam storage/public/barcode/
        Storage::put($fileName, $content);

        if ($request->file('image_file')) {
            $extension = $request->file('image_file')->getClientOriginalExtension();
            $fileName = $kodeproduk . '.' . $extension;
            $request->file('image_file')->storeAs('produk', $fileName);
            $image = $request['image'] = $fileName;
        }

        Produk::create([
            'kodeproduk'        =>  $kodeproduk,
            'jenis_id'          =>  $request->jenis_id,
            'nama'              =>  $request->nama,
            'harga_jual'        =>  $request->hargajual,
            'harga_beli'        =>  $request->hargabeli,
            'keterangan'        =>  $request->keterangan,
            'berat'             =>  $request->berat,
            'karat'             =>  $request->karat,
            'image'             =>  $image,
            'status'            =>  $request->status
        ]);

        return redirect('produk')->with('success-message', 'Data Success Disimpan !');
    }
}
