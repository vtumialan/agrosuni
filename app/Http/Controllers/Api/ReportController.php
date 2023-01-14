<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAllReports()
    {
        $ordersProducts = Order::select(
            DB::raw('p.id, p.name, year(orders.date) year, month(orders.date) month, sum(op.unid) sum')
        )
            ->join('orders_products as op', 'orders.id', '=', 'op.order_id')
            ->join('products as p', 'op.product_id', '=', 'p.id')
            ->groupBy('p.id', 'p.name', DB::raw('year(orders.date)'), DB::raw('month(orders.date)'))
            ->where('orders.status', 3)
            ->orderBy(DB::raw('year(orders.date)'), 'DESC')
            ->orderBy(DB::raw('month(orders.date)'), 'DESC')
            ->get();

        $productsCosts = Product::select(
            DB::raw('
                products.id, products.name, year(o.date) year, month(o.date) month, sum(op.unid * op.price) total
            ')
        )
            ->join('orders_products as op', 'products.id', '=', 'op.product_id')
            ->join('orders as o', 'op.order_id', '=', 'o.id')
            ->groupBy('products.id', 'products.name', DB::raw('year(o.date)'), DB::raw('month(o.date)'))
            ->where('o.status', 3)
            ->orderBy(DB::raw('year(o.date)'), 'DESC')
            ->orderBy(DB::raw('month(o.date)'), 'DESC')
            ->get();

        $providersProducts = Provider::select(
            DB::raw('providers.id, providers.name, p.name product_name, year(o.date) year, month(o.date) month, sum(op.unid) sum')
        )
            ->join('orders as o', 'providers.id', '=', 'o.provider_id')
            ->join('orders_products as op', 'o.id', '=', 'op.order_id')
            ->join('products as p', 'op.product_id', '=', 'p.id')
            ->groupBy('providers.id', 'providers.name', 'p.name', DB::raw('year(o.date)'), DB::raw('month(o.date)'))
            ->orderBy(DB::raw('year(o.date)'), 'DESC')
            ->orderBy(DB::raw('month(o.date)'), 'DESC')
            ->get();

        $providersCosts =  Provider::select(
            DB::raw('
                    providers.id, providers.name, year(o.date) year, month(o.date) month, sum(op.unid * op.price) total
                ')
        )
            ->join('orders as o', 'providers.id', '=', 'o.provider_id')
            ->join('orders_products as op', 'o.id', '=', 'op.order_id')
            ->groupBy('providers.id', 'providers.name', DB::raw('year(o.date)'), DB::raw('month(o.date)'))
            ->where('o.status', 3)
            ->orderBy(DB::raw('year(o.date)'), 'DESC')
            ->orderBy(DB::raw('month(o.date)'), 'DESC')
            ->get();

        $storeProducts = Store::select(
            DB::raw('stores.id, stores.name, products.name product_name, sum(stores_products.unid) total')
        )
            ->join('stores_products', 'stores.id', '=', 'stores_products.store_id')
            ->join('products', 'stores_products.product_id', '=', 'products.id')
            ->groupBy('products.name', 'stores.name', 'stores.id')
            ->orderBy('stores.id', 'ASC')
            ->orderBy('products.name', 'ASC')
            ->get();

        return [
            'ordersProducts' => $ordersProducts,
            'productsCosts' => $productsCosts,
            'providersProducts' => $providersProducts,
            'providersCosts' => $providersCosts,
            'storeProducts' => $storeProducts,
        ];
    }
}
