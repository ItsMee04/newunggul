<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with(['pegawai', 'role'])->get();
        $count = User::where('status', 1)->count();
        return view('pages.user', ['user' => $user, 'count' => $count]);
    }

    public function getUser()
    {
        $user = User::with(['pegawai', 'role'])->where('status', 1)->get();
        $count   = User::where('status', 1)->count();
        return response()->json(['success' => true, 'message' => 'Data Pegawai Ditemukan', 'Data' => $user, 'Total' => $count]);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->with(['pegawai', 'role'])->get();
        return response()->json(['success' => true, 'message' => 'Data Pegawai Berhasil Ditemukan', 'data' => $user]);
    }

    public function update(Request $request, $id)
    {

        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'unique'   => ':attribute sudah digunakan'
        ];

        $credentials = $request->validate([
            'email'     => 'required|unique:users',
            'password'  => 'required',
        ], $messages);

        User::where('id', $id)
            ->update([
                'email' =>  $request->email,
                'password'  =>  Hash::make($request->password)
            ]);

        return response()->json(['success' => true, 'message' => "Data User Berhasil Disimpan"]);
    }
}
