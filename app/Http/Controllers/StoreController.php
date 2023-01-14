<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StoreCollection;

class StoreController extends Controller
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

        $list = Store::where('status', 1)
            ->offset(($page - 1) * $limit)
            ->paginate($limit);

        return Inertia::render('Stores/Index', ['stores' => new StoreCollection($list)]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        return Inertia::render('Stores/Create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'type' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'contact' => ['required'],
        ])->validate();

        $data = $request->all();

        Store::create([
            'name' => $data['name'],
            'type' => $data['type']['key'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'contact' => $data['contact']
        ]);

        return redirect()->route('stores.index');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function edit(Store $store)
    {
        if ($store->type == 'almacen') {
            $type = ['id' => '1', 'key' => 'almacen', 'name' => 'Almacén'];
        } else {
            $type = ['id' => '2', 'key' => 'tienda', 'name' => 'Tienda'];
        }

        return Inertia::render('Stores/Edit', [
            'store' => $store,
            'type' => $type
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required'],
            'type' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'contact' => ['required'],
        ])->validate();

        Store::find($id)->update($request->all());
        return redirect()->route('stores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy($id)
    {
        Store::find($id)->update([
            'status' => false
        ]);
        return redirect()->route('stores.index');
    }
}
