<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;
use App\Models\Suplier;

class StokBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'tanggal_masuk',
        'no_transaksi',
        'suplier_id',
        'qty'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function suplier()
    {
        return $this->belongsTo(Suplier::class);
    }
}