<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class kategoriModel extends Model
{
    use HasFactory;

    protected $table = 'kategori_pakaian';
    public $timestamps = false;
    protected $primaryKey = 'kategori_pakaian_id';
    protected $fillable = [
        'kategori_pakaian_nama',
    ];

}
