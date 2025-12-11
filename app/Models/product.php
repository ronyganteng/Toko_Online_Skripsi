<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';   // kalau nama tabelmu 'product', ubah ke 'product'

    // Biar semua kolom yang kita pakai BOLEH di-isi
    protected $fillable = [
        'sku',
        'nama_product',
        'type',
        'kategory',
        'harga',
        'deskripsi',
        'discount',
        'quantity',
        'quantity_out',
        'foto',
        'is_active',
    ];
}
