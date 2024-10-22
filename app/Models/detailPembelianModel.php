<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detailPembelianModel extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail';
    protected $primaryKey = 'pembelian_detail_id';
    public $timestamps = false;

    protected $fillable = [
        'pembelian_id',
        'pakaian_id',
        'pembelian_detail_jumlah',
        'pembelian_detail_total_harga',
    ];

    public function pembelian()
    {
        return $this->belongsTo(pembelianModel::class, 'pembelian_id', 'pembelian_id');
    }

    public function pakaian()
    {
        return $this->belongsTo(pakaianModel::class, 'pakaian_id', 'pakaian_id');
    }
}