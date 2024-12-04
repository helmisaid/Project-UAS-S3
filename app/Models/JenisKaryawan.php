<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKaryawan extends Model
{
    protected $table = 'jenis_karyawan'; // Jika nama tabel Anda tidak sesuai dengan konvensi Laravel

    protected $primaryKey = 'id_jenis_karyawan';
    protected $fillable = [
        'jenis_karyawan'
    ];


    public function karyawans()
{
    return $this->hasMany(Karyawan::class, 'id_jenis_karyawan');
}

}
