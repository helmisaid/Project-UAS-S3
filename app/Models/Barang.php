<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'idbarang';

    public $timestamps = false; // Nonaktifkan penggunaan timestamps

    protected $fillable = [
        'jenis',
        'nama',
        'idsatuan',
        'status',
        'harga',
    ];
}


