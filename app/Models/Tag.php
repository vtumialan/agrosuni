<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status'
    ];

    protected $hidden = [
        'status'
    ];

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'products_tags', 'tag_id', 'product_id');
    }
}
