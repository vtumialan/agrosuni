<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\Http\Resources\ProviderCollection;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
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

        $list = Provider::where('status', 1)
                        ->offset(($page - 1) * $limit)
                        ->paginate($limit);

        return new ProviderCollection($list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return Provider::where('status', 1)->get();
    }
}