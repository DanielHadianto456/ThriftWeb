<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pakaianModel extends Model
{
    use HasFactory;

    protected $table = 'pakaian';
    public $timestamps = false;
    protected $primaryKey = 'pakaian_id';
    protected $fillable = [
        'kategori_pakaian_id',
        'pakaian_nama',
        'pakaian_harga',
        'pakaian_stok',
        'pakaian_gambar_url',
    ];

    public function kategori()
    {
        return $this->belongsTo(kategoriModel::class, 'kategori_pakaian_id', 'kategori_pakaian_id');
    }
}
