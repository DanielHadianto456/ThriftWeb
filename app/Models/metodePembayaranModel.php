<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class metodePembayaranModel extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'metode_pembayaran_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'metode_pembayaran_jenis',
        'metode_pembayaran_nomor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function pembelian()
    {
        return $this->hasMany(pembelianModel::class, 'metode_pembayaran_id', 'metode_pembayaran_id');
    }
}