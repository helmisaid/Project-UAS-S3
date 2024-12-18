<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuLevel extends Model
{
    use HasFactory;

    protected $table = 'menu_level';
    protected $primaryKey = 'level_id';
    public $timestamps = false;
    public $incrementing = false;

    // Field yang dapat diisi melalui form
    protected $fillable = [
        'level_id',
        'level',
        'create_by',
    ];
}
