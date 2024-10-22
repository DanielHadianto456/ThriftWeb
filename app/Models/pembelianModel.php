<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pembelianModel extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'pembelian_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'metode_pembayaran_id',
        'pembelian_tanggal',
        'pembelian_total_harga',
    ];

    public function user()
    {
        return $this->belongsTo(userModel::class, 'user_id', 'user_id');
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(metodePembayaranModel::class, 'metode_pembayaran_id', 'metode_pembayaran_id');
    }

    public function detailPembelian()
    {
        return $this->hasMany(detailPembelianModel::class, 'pembelian_id', 'pembelian_id');
    }
}