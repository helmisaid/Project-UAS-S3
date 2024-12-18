<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettingMenuUser extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model
    protected $table = 'setting_menu_user';

    // Primary key dari tabel, sesuai dengan skema (bukan auto-increment)
    protected $primaryKey = 'no_setting';


    // Field yang dapat diisi melalui form
    protected $fillable = [
        'no_setting',
        'id_jenis_karyawan',
        'menu_id',
        'created_by',
    ];

    public function jenisKaryawan()
    {
        return $this->belongsTo(JenisKaryawan::class, 'id_jenis_karyawan', 'id_jenis_karyawan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'menu_id');
    }
}
