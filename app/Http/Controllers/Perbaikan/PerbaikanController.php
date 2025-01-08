<?php

namespace App\Http\Controllers\Perbaikan;

use App\Http\Controllers\Controller;
use App\Models\Perbaikan;
use Illuminate\Http\Request;

class PerbaikanController extends Controller
{
    public function index()
    {
        return view('pages.perbaikan');
    }

    public function getPerbaikan()
    {
        $perbaikan = Perbaikan::with([
            'produk',
            'user.pegawai'
        ])->get();

        return response()->json(['success' => true, 'message' => 'Data Perbaikan Berhasil Ditemukan', 'Data' => $perbaikan]);
    }
}
