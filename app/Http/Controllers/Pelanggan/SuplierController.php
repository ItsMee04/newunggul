<?php

namespace App\Http\Controllers\Pelanggan;

use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SuplierController extends Controller
{
    private function generateCodeSuplier()
    {
        // Ambil kode customer terakhir dari database
        $lastCustomer = DB::table('suplier')
            ->orderBy('kodesuplier', 'desc')
            ->first();

        // Jika tidak ada customer, mulai dari 1
        $lastNumber = $lastCustomer ? (int) substr($lastCustomer->kodesuplier, -5) : 0;

        // Tambahkan 1 pada nomor terakhir
        $newNumber = $lastNumber + 1;

        // Format kode customer baru
        $newKodeCustomer = '#S-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        return $newKodeCustomer;
    }

    public function index()
    {
        $suplier = Suplier::all();
        return view('pages.suplier', ['suplier' => $suplier]);
    }

    public function store(Request $request)
    {
        $generateCode = $this->generateCodeSuplier();

        $messages = [
            'required'  => ':attribute wajib di isi !!!',
            'integer'   => ':attribute format wajib menggunakan angka',
            'numeric'   => ':attribute format wajib menggunakan angka',
        ];

        $credentials = $request->validate([
            'suplier'         => 'required',
            'alamat'          => 'required',
            'kontak'          => 'required|numeric',
            'status'          => 'required',
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('supplier')->with('errors-message', 'Status wajib di isi !!!');
        }

        $request['kodesuplier'] = $generateCode;
        $suplier = Suplier::create($request->all());

        return redirect('suplier')->with('success-message', 'Data Suplier Berhasil Disimpan');
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'required'  => ':attribute wajib di isi !!!',
            'integer'   => ':attribute format wajib menggunakan angka',
            'numeric'   => ':attribute format wajib menggunakan angka',
        ];

        $credentials = $request->validate([
            'suplier'         => 'required',
            'alamat'          => 'required',
            'kontak'          => 'required|numeric',
            'status'          => 'required',
        ], $messages);

        if ($request->status == 'Pilih Status') {
            return redirect('supplier')->with('errors-message', 'Status wajib di isi !!!');
        }

        $suplier = Suplier::findOrFail($id);

        $suplier->update($request->all());
        return redirect('suplier')->with('success-message', 'Data Suplier Berhasil Disimpan');
    }

    public function delete($id)
    {
        $suplier = Suplier::find($id);

        $suplier->delete();

        return response()->json(['success' => true, 'message' => 'Data Suplier Berhasil Dihapus']);
    }
}
