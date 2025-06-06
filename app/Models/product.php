<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = [
        'sku',
        'nama_produk',
        'type',
        'kategory',
        'harga',
        'discount',
        'quantity',
        'quantity_out',
        'foto',
        'is_active',
    ];
    //public function product()
    //{
     //   return $this->hasOne(TblCart::class,'', 'id');
    //}
}
