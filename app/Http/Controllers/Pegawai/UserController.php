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

        User::where('pegawai_id', $id)
            ->update([
                'email' =>  $request->email,
                'password'  =>  Hash::make($request->password)
            ]);

        return redirect('user')->with('success-message', 'Data User Berhasil Disimpan');
    }
}
