<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendor'; // Nama tabel di database
    protected $primaryKey = 'idvendor'; // Primary key tabel

    protected $fillable = [
        'nama_vendor',
        'badan_hukum',
        'status',
    ];

    public $timestamps = false; // Nonaktifkan otomatis created_at dan updated_at
}
