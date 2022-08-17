<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detail';
    protected $fillable = [
        'no_transaksi',
        'barang_id',
        'jumlah',
        'harga_jual',
    ];
}
