<?php

namespace App\Http\Controllers\Produk;

use App\Models\Jenis;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
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
        $count = Produk::where('status', 1)->count();
        return view('pages.produk', ['produk' => $produk, 'jenis' => $jenis, 'count' => $count]);
    }

    public function getProduk()
    {
        $produk = Produk::where('status', 1)->with(['jenis', 'kondisi'])->get();
        $count = Produk::where('status', 1)->count();
        return response()->json(['success' => true, 'message' => 'Data Produk Berhasil Ditemukan', 'Data' => $produk, 'Total' => $count]);
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
                'regex:/^\d+\.\d{1,}$/'
            ],
            'kondisi_id'    =>  'required',
            'karat'         =>  'required|integer',
            'image_file'    =>  'nullable|mimes:png,jpg',
        ], $messages);

        if ($request->jenis_id == 'Pilih Jenis') {
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

        $data = Produk::create([
            'kodeproduk'        =>  $kodeproduk,
            'jenis_id'          =>  $request->jenis_id,
            'nama'              =>  $request->nama,
            'harga_jual'        =>  $request->hargajual,
            'harga_beli'        =>  $request->hargabeli,
            'keterangan'        =>  $request->keterangan,
            'berat'             =>  $request->berat,
            'karat'             =>  $request->karat,
            'kondisi_id'        =>  $request->kondisi_id,
            'image'             =>  $image,
            'status'            =>  1,
        ]);

        return response()->json(['success' => true, 'message' => 'Data Produk Berhasil Disimpan', 'Data' => $data]);
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data Produk Berhasil Ditemukan', 'data' => $produk]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::where('kodeproduk', $id)->first();

        $messages = [
            'required' => ':attribute wajib di isi !!!',
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
                'regex:/^\d+\.\d{1,}$/'
            ],
            'karat'         =>  'required|integer',
            'kondisi_id'    =>  'required',
            'avatar'        =>  'nullable|mimes:png,jpg',
        ], $messages);

        if ($request->file('avatar')) {
            $pathavatar     = 'storage/produk/' . $produk->image;

            if (File::exists($pathavatar)) {
                File::delete($pathavatar);
            }

            $extension = $request->file('avatar')->getClientOriginalExtension();
            $newImage = $produk->kodeproduk . '.' . $extension;
            $request->file('avatar')->storeAs('produk', $newImage);
            $request['image'] = $newImage;

            $updateProduk = Produk::where('kodeproduk', $id)
                ->update([
                    'nama'              =>  $request->nama,
                    'harga_jual'        =>  $request->hargajual,
                    'harga_beli'        =>  $request->hargabeli,
                    'keterangan'        =>  $request->keterangan,
                    'berat'             =>  $request->berat,
                    'karat'             =>  $request->karat,
                    'kondisi_id'        =>  $request->kondisi_id,
                    'image'             =>  $newImage,
                ]);
        } else {
            $updateProduk = Produk::where('kodeproduk', $id)
                ->update([
                    'nama'              =>  $request->nama,
                    'harga_jual'        =>  $request->hargajual,
                    'harga_beli'        =>  $request->hargabeli,
                    'keterangan'        =>  $request->keterangan,
                    'berat'             =>  $request->berat,
                    'karat'             =>  $request->karat,
                    'kondisi_id'        =>  $request->kondisi_id,
                ]);
        }

        return response()->json(['success' => true, 'message' => 'Data Produk Berhasil Disimpan', 'Data' => $produk]);
    }

    public function delete($id)
    {
        Produk::where('id', $id)->update(['status' => 0]);
        return response()->json(['message' => 'Data berhasil dihapus.']);
    }

    public function streamBarcode($id)
    {

        $produk = Produk::where('id', $id)->first();
        $filePath = 'storage/barcode/' . $produk->kodeproduk . '.png';

        if (File::exists($filePath)) {
            $file = fopen($filePath, 'r'); // Membuka file untuk dibaca

            return response()->stream(function () use ($file) {
                while (!feof($file)) {
                    echo fread($file, 1024); // Membaca file per 1024 byte
                }
                fclose($file); // Menutup file setelah selesai
            }, 200, [
                'Content-Type' => 'image/png',  // Ganti sesuai dengan tipe file Anda
                'Content-Disposition' => 'attachment; filename="' . $produk . '"'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Data Barcode Tidak Ditemukan']);
    }

    public function downloadBarcode($id)
    {
        $produk = Produk::where('id', $id)->first();
        $filePath = 'storage/barcode/' . $produk->kodeproduk . '.png';

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return response()->json(['success' => false, 'message' => 'Data Barcode Tidak Ditemukan']);
    }

    public function scanner()
    {
        return view('pages.scan');
    }

    public function scanDetail($id)
    {
        $produk = Produk::where('kodeproduk', $id)->get();

        return view('pages.scanbarcode', ['produk' => $produk]);
    }

    public function scanqr(Request $request)
    {
        $id = $request->qr_code;
        $qrcodeid = Produk::where('kodeproduk', $id)->first()->id;

        if ($id == $qrcodeid) {
            return response()->json([
                'status' => 200,
                'produk' => $qrcodeid
            ]);
        } else {
            return response()->json(
                [
                    'status' => 400,
                    'produk tidak ditemukan'
                ]
            );
        }
    }
}
