<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuStok extends Model
{
    protected $table = 'kartu_stok';
    protected $primaryKey = 'idkartu_stk';

    // Relationship with Barang model
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'idbarang', 'idbarang');
    }
}
