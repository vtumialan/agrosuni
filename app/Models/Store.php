<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'phone',
        'address',
        'contact',
        'status'
    ];

    protected $hidden = [
        'status'
    ];

    public function products() {
        return $this->hasMany('App\Models\StoreProduct', 'store_id', 'id');
    }
}
