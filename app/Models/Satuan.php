<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $table = 'satuan'; // Nama tabel di database

    protected $primaryKey = 'idsatuan'; // Nama kolom primary key

    public $timestamps = false; // Nonaktifkan timestamps jika tidak digunakan

    protected $fillable = [
        'nama_satuan',
        'status',
    ];
}
