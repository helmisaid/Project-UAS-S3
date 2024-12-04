<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Karyawan extends Authenticatable
{
    public $timestamps = false;
    protected $table = 'karyawan'; // Jika nama tabel Anda tidak sesuai dengan konvensi Laravel

    protected $primaryKey = 'id_karyawan';  // Jika kolom primary key bukan 'id'
    public $incrementing = true;  // J

    protected $fillable = [
        'nama_karyawan', 'alamat', 'no_telp', 'email', 'password', 'status', 'foto_karyawan', 'id_jenis_karyawan'
    ];


    public function jenisKaryawan()
    {
        return $this->belongsTo(JenisKaryawan::class, 'id_jenis_karyawan', 'id_jenis_karyawan');
    }

}
