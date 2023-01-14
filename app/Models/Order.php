<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'store_id',
        'provider_id',
        'type',
        'date',
        'status'
    ];

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function store() {
        return $this->hasOne('App\Models\Store', 'id', 'store_id');
    }

    public function provider() {
        return $this->hasOne('App\Models\Provider', 'id', 'provider_id');
    }

    public function listproducts() {
        return OrderProduct::select('products.id', 'products.name', 'orders_products.price', 'orders_products.unid')
                            ->join('products', 'orders_products.product_id', '=', 'products.id')
                            ->where('orders_products.order_id', $this->id)
                            ->get();
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'orders_products', 'order_id', 'product_id');
    }

    public function getTotalAttribute() {
        return DB::table('orders_products')
                    ->where('orders_products.order_id', $this->id)
                    ->sum(DB::raw('orders_products.price * orders_products.unid'));
    }

    public function getTypeNameAttribute() {
        if ($this->type == 1) {
            return "Manual";
        } elseif ($this->type == 2) {
            return "Automática";
        } else {
            return " - ";
        }
    }

    public function getStatusNameAttribute() {
        $name = " - ";
        if ($this->status == 0) {
            $name = "Creada";
        } elseif ($this->status == 1) {
            $name = "Pendiente";
        } elseif ($this->status == 2) {
            $name = "En curso";
        } elseif ($this->status == 3) {
            $name = "Finalizada";
        } elseif ($this->status == 4) {
            $name = "Rechazada";
        } elseif ($this->status == 5) {
            $name = "Cancelada";
        }
        return $name;
    }
}
