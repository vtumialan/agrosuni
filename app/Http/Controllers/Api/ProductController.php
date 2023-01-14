<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductCollection;
use App\Models\StoreProduct;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->has('page') ? $request->get('page') : 1;
        $limit = $request->has('limit') ? $request->get('limit') : 10;

        $list = Product::where('status', 1)
                        ->offset(($page - 1) * $limit)
                        ->paginate($limit);

        return new ProductCollection($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return Product::where('status', 1)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getStock($store = 'all')
    {
        $list = StoreProduct::selectRaw("products.id, products.name, SUM(unid) as unit")
                            ->join('products', 'stores_products.product_id', '=', 'products.id')
                            ->groupBy('product_id');
        if ($store != 'all') {
            $list->where('stores_products.store_id', $store);
        }
        return $list->get();
    }
}
