<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;

    protected $table = 'products_tags';

    protected $fillable = [
        'product_id',
        'tag_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
