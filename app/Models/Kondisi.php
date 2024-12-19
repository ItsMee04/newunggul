<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kondisi extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at']; // Menyembunyikan created_at dan updated_at secara global
    protected $table = 'kondisi';
    protected $fillable = [
        'id',
        'kondisi',
        'status'
    ];
}
