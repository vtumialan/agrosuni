<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferProduct extends Model
{
    use HasFactory;
    protected $table = 'transfers_products';
    public $timestamps = false;

    protected $fillable = [
        'transfer_id',
        'product_id',
        'unid',
    ];
}
