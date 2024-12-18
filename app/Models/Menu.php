<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    public $timestamps = false;
    protected $primaryKey = 'menu_id';
    protected $fillable = [
     'menu_name', 'menu_link', 'menu_icon', 'level_id', 'parent_id', 'created_by'
    ];

    
}
