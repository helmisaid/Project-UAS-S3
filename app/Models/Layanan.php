<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_layanan';

    // Menentukan nama tabel yang digunakan di database
    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan', 'harga_layanan', 'id_karyawan'
    ];

    // Relasi ke Karyawan (One-to-Many)
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
