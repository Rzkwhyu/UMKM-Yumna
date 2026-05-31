<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pt', 'no_telp', 'logo'];

    public function stokBarang()
    {
        return $this->hasMany(StokBarang::class);
    }
}
