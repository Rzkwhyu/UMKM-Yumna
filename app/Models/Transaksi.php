<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_transaksi',
        'barang_id',
        'nama_pembeli',
        'qty',
        'total_harga',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}