<?php

namespace App\Models;

use App\Models\PenjualanDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    
    protected $table = 'penjualan';
    protected $fillable = [
        'no_transaksi',
        'total',
        'bayar',
        'user_id',
        'selisih',
    ];
    
    public function detail(){
        return $this->hasMany(PenjualanDetail::class,'no_transaksi','no_transaksi');
    }
}
