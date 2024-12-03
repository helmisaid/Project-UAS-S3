<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'status',
        'id_karyawan', // Kolom yang menghubungkan layanan dengan karyawan
    ];

    // Relasi dengan model Karyawan (Jika hubungan satu ke banyak)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }

    public $primaryKey = 'id_layanan';
    public $incrementing = true;
    protected $keyType = 'int';
}
