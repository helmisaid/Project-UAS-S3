<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarginPenjualan extends Model
{
    use HasFactory;

    protected $table = 'margin_penjualan';
    protected $primaryKey = 'idmargin_penjualan';
    protected $fillable = ['persen', 'status', 'id_karyawan'];

    public $timestamps = true;  // Menyesuaikan dengan kolom created_at dan updated_at

    // Model MarginPenjualan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan'); // Pastikan id_karyawan ada di tabel MarginPenjualan
    }

}
