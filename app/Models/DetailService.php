<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailService extends Model
{
    use HasFactory;

    protected $table = 'detail_service';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;
    
    protected $fillable = [
        'id_service',
        'id_layanan',
        'id_barang',
        'jumlah',
        'subtotal'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'id_service', 'id_service');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan', 'id_layanan');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'idbarang');
    }
}

