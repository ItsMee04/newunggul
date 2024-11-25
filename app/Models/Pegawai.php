<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pegawai';
    protected $fillable =
    [
        'nip',
        'nama',
        'alamat',
        'kontak',
        'jabatan_id',
        'image',
        'status'
    ];
}
