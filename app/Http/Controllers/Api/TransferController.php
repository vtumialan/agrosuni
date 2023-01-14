<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Http\Resources\TransferCollection;

class TransferController extends Controller
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

        $list = Transfer::offset(($page - 1) * $limit)
                        ->paginate($limit);

        return new TransferCollection($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return Transfer::get();
    }
}
