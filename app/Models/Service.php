<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';
    protected $primaryKey = 'id_service';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_service',
        'id_karyawan',
        'id_mekanik',
        'nomor_antrian',
        'nama_pelanggan',
        'no_telp',
        'no_pol',
        'jenis_kendaraan',
        'tanggal',
        'subtotal_nilai',
        'total_nilai',
        'total_bayar',
        'diskon',
        'ppn',
        'status',
        'keterangan'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function mekanik()
    {
        return $this->belongsTo(Karyawan::class, 'id_mekanik', 'id_karyawan');
    }

    public function detailService()
    {
        return $this->hasMany(DetailService::class, 'id_service', 'id_service');
    }
}

