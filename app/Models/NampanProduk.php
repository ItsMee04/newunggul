<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NampanProduk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nampan_produk';
    protected $fillable =
    [
        'nampan_id',
        'produk_id',
        'tanggal',
        'status'
    ];

    /**
     * Get the nampan that owns the NampanProduk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nampan(): BelongsTo
    {
        return $this->belongsTo(Nampan::class, 'nampan_id', 'id');
    }

    /**
     * Get the produk that owns the NampanProduk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
}
