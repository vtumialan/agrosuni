<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_completed_id',
        'origin_store_id',
        'destination_store_id',
        'created_date',
        'completed_date',
        'status'
    ];

    public function user_created() {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function user_completed() {
        return $this->hasOne('App\Models\User', 'id', 'user_completed_id');
    }

    public function origin_store() {
        return $this->hasOne('App\Models\Store', 'id', 'origin_store_id');
    }

    public function destination_store() {
        return $this->hasOne('App\Models\Store', 'id', 'destination_store_id');
    }

    public function listproducts() {
        return TransferProduct::select('products.id', 'products.name', 'transfers_products.unid')
                            ->join('products', 'transfers_products.product_id', '=', 'products.id')
                            ->where('transfers_products.transfer_id', $this->id)
                            ->get();
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'transfers_products', 'transfer_id', 'product_id');
    }

    public function getStatusNameAttribute() {
        if ($this->status == 0) {
            return "Solicitada";
        } elseif ($this->status == 1) {
            return "Finalizada";
        } elseif ($this->status == 2) {
            return "Cancelada";
        }
    }
}
