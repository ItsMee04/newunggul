<?php

namespace App\Http\Controllers\Produk;

use App\Http\Controllers\Controller;
use App\Models\Kondisi;
use Illuminate\Http\Request;

class KondisiController extends Controller
{
    public function index() {}

    public function getKondisi()
    {
        $kondisi = Kondisi::all();
        return response()->json(['success' => true, 'message' => 'Data Kondisi Berhasil Ditemukan', 'Data' => $kondisi]);
    }
}
