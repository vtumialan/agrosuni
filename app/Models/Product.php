<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'type_id',
        'status'
    ];

    protected $hidden = [
        'status'
    ];

    public function providers() {
        return $this->belongsToMany('App\Models\Provider', 'products_providers', 'product_id', 'provider_id');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'products_tags', 'product_id', 'tag_id');
    }

    public function type() {
        return $this->hasOne('App\Models\Type', 'id', 'type_id');
    }

    public function orders() {
        return $this->belongsToMany('App\Models\Order', 'orders_products', 'product_id', 'order_id');
    }
}
