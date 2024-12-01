<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembelian extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at']; // Menyembunyikan created_at dan updated_at secara global
    protected $table = 'pembelian';
    protected $fillable = [
        'id',
        'kodepembelian',
        'suplier_id',
        'pelanggan_id',
        'kodeproduk',
        'jenis_id',
        'nama',
        'harga_beli',
        'berat',
        'karat',
        'kondisi',
        'keterangan',
        'image',
        'status'
    ];

    /**
     * Get the suplier that owns the Pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function suplier(): BelongsTo
    {
        return $this->belongsTo(Suplier::class, 'suplier_id', 'id');
    }

    /**
     * Get the pelanggan that owns the Pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id');
    }

    /**
     * Get the jenis that owns the Pembelian
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'id');
    }
}
