<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderCollection;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
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

        $list = Order::offset(($page - 1) * $limit)
                    ->orderBy('date', 'desc')->paginate($limit);

        return new OrderCollection($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return Order::where('status', 1)->get();
    }
}
