<?php

namespace App\Http\Controllers\Pegawai;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with(['pegawai', 'role'])->get();
        $count = User::where('status', 1)->count();
        return view('pages.user', ['user' => $user, 'count' => $count]);
    }
}
