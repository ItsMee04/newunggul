<?php

namespace App\Models;

use App\Models\Jenis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "produk";
    protected $fillable = [
        'kodeproduk',
        'jenis_id',
        'nama',
        'harga_jual',
        'harga_beli',
        'keterangan',
        'berat',
        'karat',
        'image',
        'status',
    ];

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'id');
    }
}
