<?php

namespace App\Http\Controllers\Stok;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        return view('pages.stok');
    }

    public function getStokByNampan()
    {
        $stok = Stok::with(['nampan'])->where('status', 1)->get();
        return response()->json(['success' => true, 'message' => 'Data Stok Berhasil Ditemukan', 'Data' => $stok]);
    }
}
