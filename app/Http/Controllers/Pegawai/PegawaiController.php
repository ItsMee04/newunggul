<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('pages.pegawai');
    }

    public function getpegawai()
    {
        $pegawai = Pegawai::with('jabatan')->get();
        $count   = Pegawai::count();
        return response()->json(['success' => true, 'message' => 'Data Pegawai Ditemukan', 'Data' => $pegawai, 'Total' => $count]);
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'mimes'    => ':attribute format wajib menggunakan PNG/JPG',
            'unique'   => ':attribute sudah digunakan'
        ];

        $credentials = $request->validate([
            'nip'           =>  'required|unique:pegawai',
            'avatar'        => 'mimes:png,jpg,jpeg',
        ], $messages);

        if ($request->jabatan == 'Pilih Jabatan') {
            return redirect('pegawai')->with('errors-message', 'Jabatan Harus Di Pilih');
        } elseif ($request->status == 'Pilih Status') {
            return redirect('pegawai')->with('errors-message', 'Status Harus Di Pilih');
        }

        $newAvatar = '';

        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $newAvatar = $request->nip . '.' . $extension;
            $request->file('image')->storeAs('Avatar', $newAvatar);
            $request['image'] = $newAvatar;
        }

        $store = Pegawai::create([
            'nip'           => $request->nip,
            'nama'          => $request->nama,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
            'jabatan_id'    => $request->jabatan,
            'status'        => $request->status,
            'image'         => $newAvatar,
        ]);

        $pegawai_id = Pegawai::where('nip', '=', $request->nip)->first()->id;

        if ($store) {
            User::create([
                'pegawai_id' => $pegawai_id,
                'role_id'    => $request->jabatan,
                'status'     => $request->status
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Data Pegawai Berhasil Disimpan']);
    }

    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Data Pegawai Berhasil Ditemukan', 'data' => $pegawai]);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::where('id', $id)->first();

        $messages = [
            'required' => ':attribute wajib di isi !!!',
            'mimes'    => ':attribute format wajib menggunakan PNG/JPG'
        ];

        $credentials = $request->validate([
            'nama'          => 'required',
            'kontak'        => 'required',
            'jabatan'       => 'required',
            'alamat'        => 'required',
            'status'        => 'required',
            'avatar'        => 'mimes:png,jpg,jpeg',
        ], $messages);

        if ($request->file('avatar')) {
            $pathavatar     = 'storage/Avatar/' . $pegawai->image;

            if (File::exists($pathavatar)) {
                File::delete($pathavatar);
            }

            $extension = $request->file('avatar')->getClientOriginalExtension();
            $newAvatar = $request->nip . '.' . $extension;
            $request->file('avatar')->storeAs('Avatar', $newAvatar);
            $request['avatar'] = $newAvatar;

            $updatepegawai = Pegawai::where('id', $id)
                ->update([
                    'nama'          => $request->nama,
                    'alamat'        => $request->alamat,
                    'kontak'        => $request->kontak,
                    'jabatan_id'    => $request->jabatan,
                    'status'        => $request->status,
                    'image'        => $newAvatar,
                ]);

            if ($updatepegawai) {
                User::where('pegawai_id', $id)
                    ->update([
                        'role_id'   =>  $request->jabatan,
                        'status'    =>  $request->status
                    ]);
            }
        } else {
            $updatepegawai = Pegawai::where('id', $id)
                ->update([
                    'nama'          => $request->nama,
                    'alamat'        => $request->alamat,
                    'kontak'        => $request->kontak,
                    'jabatan_id'    => $request->jabatan,
                    'status'        => $request->status
                ]);

            if ($updatepegawai) {
                User::where('pegawai_id', $id)
                    ->update([
                        'role_id'   =>  $request->jabatan,
                        'status'    =>  $request->status
                    ]);
            }
        }
        return response()->json(['success' => true, 'message' => "Data Pegawai Berhasil Disimpan", 'Data' => $pegawai]);
    }

    public function delete($id)
    {
        $user    = User::where('pegawai_id', $id)->first();
        $hapuspegawai = Pegawai::where('id', $id)->delete();

        if ($user != null) {
            if ($hapuspegawai) {
                User::where('pegawai_id', $id)->delete();
            }
        }

        return response()->json(['message' => 'Data berhasil dihapus.']);
    }
}
