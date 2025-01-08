<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perbaikan extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at']; // Menyembunyikan created_at dan updated_at secara global
    protected $table = 'perbaikan';
    protected $fillable = [
        'id',
        'produk_id',
        'keterangan',
        'user_id',
        'status'
    ];

    /**
     * Get the produk that owns the Perbaikan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(User::class, 'produk_id', 'id');
    }

    /**
     * Get the user that owns the Perbaikan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
