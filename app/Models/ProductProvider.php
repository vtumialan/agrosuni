<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProvider extends Model
{
    use HasFactory;

    protected $table = 'products_providers';

    protected $fillable = [
        'product_id',
        'provider_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
