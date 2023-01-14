<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Provider;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProviderCollection;

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

        return Inertia::render('Providers/Index', ['providers' => new ProviderCollection($list)]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        return Inertia::render('Providers/Create');
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
            'document_id' => ['required'],
            'contact' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'email' => ['required'],
        ])->validate();

        Provider::create($request->all());

        return redirect()->route('providers.index');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function edit(Provider $provider)
    {
        return Inertia::render('Providers/Edit', [
            'provider' => $provider
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
            'document_id' => ['required'],
            'contact' => ['required'],
            'phone' => ['required'],
            'address' => ['required'],
            'email' => ['required'],
        ])->validate();

        Provider::find($id)->update($request->all());
        return redirect()->route('providers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy($id)
    {
        Provider::find($id)->update([
            'status' => false
        ]);
        return redirect()->route('providers.index');
    }
}
