<?php

namespace App\Http\Controllers\Pelanggan;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PelangganController extends Controller
{
    private function generateCodePelanggan()
    {
        // Ambil kode customer terakhir dari database
        $lastCustomer = DB::table('pelanggan')
            ->orderBy('kodepelanggan', 'desc')
            ->first();

        // Jika tidak ada customer, mulai dari 1
        $lastNumber = $lastCustomer ? (int) substr($lastCustomer->kodepelanggan, -5) : 0;

        // Tambahkan 1 pada nomor terakhir
        $newNumber = $lastNumber + 1;

        // Format kode customer baru
        $newKodeCustomer = '#C-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKodeCustomer;
    }

    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pages.pelanggan', ['pelanggan' => $pelanggan]);
    }

    public function store(Request $request)
    {
        $generateCode = $this->generateCodePelanggan();

        $messages = [
            'required'  => ':attribute wajib di isi !!!',
            'integer'   => ':attribute format wajib menggunakan angka',
            'numeric'   => ':attribute format wajib menggunakan angka',
        ];

        $credentials = $request->validate([
            'nik'             => 'required|integer|numeric',
            'nama'            => 'required',
            'alamat'          => 'required',
            'kontak'          => 'required|numeric',
            'tanggal'         => 'required',
            'status'          => 'required',
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('pelanggan')->with('errors-message', 'Status wajib di isi !!!');
        }

        $request['kodepelanggan'] = $generateCode;
        $pelanggan = Pelanggan::create($request->all());

        return redirect('pelanggan')->with('success-message', 'Data Success Di Simpan !');
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required'  => ':attribute wajib di isi !!!',
            'integer'   => ':attribute format wajib menggunakan angka',
            'numeric'   => ':attribute format wajib menggunakan angka',
        ];

        $credentials = $request->validate([
            'nik'             => 'required|integer|numeric',
            'nama'            => 'required',
            'alamat'          => 'required',
            'kontak'          => 'required|numeric',
            'tanggal'         => 'required',
            'status'          => 'required',
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('pelanggan')->with('errors-message', 'Status wajib di isi !!!');
        }

        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->update($request->all());

        return redirect('pelanggan')->with('success-message', 'Data Pelanggan Berhasil Disimpan !');
    }

    public function delete($id)
    {
        $pelanggan = Pelanggan::find($id);

        $pelanggan->delete();

        return response()->json(['success' => true, 'message' => 'Data Pelanggan Berhasil Dihapus']);
    }
}