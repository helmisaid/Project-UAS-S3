<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Retur extends Model
{
    use HasFactory;

    protected $table = 'retur';

    protected $primaryKey = 'idretur';

    public $timestamps = false;

    protected $fillable = [
        'idpenerimaan',
        'id_karyawan',
        'created_at',
    ];
}
