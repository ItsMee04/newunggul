<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('pages.pegawai', ['pegawai' => $pegawai]);
    }
}
