<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = ['nama_barang', 'kategori_id', 'harga_beli', 'harga_jual', 'stok', 'gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}

