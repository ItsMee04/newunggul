<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stok extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at']; // Menyembunyikan created_at dan updated_at secara global

    protected $table = "stok";
    protected $fillable = [
        'kodetransaksi',
        'nampan_id',
        'tanggal',
        'keterangan',
        'status'
    ];

    /**
     * Get the nampan that owns the Stok
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nampan(): BelongsTo
    {
        return $this->belongsTo(Nampan::class, 'nampan_id', 'id');
    }
}
