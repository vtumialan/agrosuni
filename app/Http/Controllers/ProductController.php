<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\ProductProvider;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Products/Index');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        return Inertia::render('Products/Create');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function show()
    {
        return Inertia::render('Products/Stock');
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
            'description' => ['required'],
            'type' => ['required'],
            'tags' => ['required'],
            'providers' => ['required'],
        ])->validate();

        $data = $request->all();

        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'type_id' => $data['type']['id'],
        ]);

        foreach ($data['tags'] as $tag) {
            ProductTag::create([
                'tag_id' => $tag['id'],
                'product_id' => $product->id
            ]);
        }

        foreach ($data['providers'] as $provider) {
            ProductProvider::create([
                'provider_id' => $provider['id'],
                'product_id' => $product->id
            ]);
        }

        return redirect()->route('products.index');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function edit(Product $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
            'providers' => $product->providers,
            'tags' => $product->tags,
            'type' => $product->type,
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
            'description' => ['required'],
            'type' => ['required'],
            'tags' => ['required'],
            'providers' => ['required'],
        ])->validate();

        $data = $request->all();

        $product = Product::find($id);
        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'type_id' => $data['type']['id'],
        ]);

        if (!empty($data['providers'])) {
            $providerIds = [];
            foreach ($data['providers'] as $provider) {
                $providerIds[] = $provider['id'];
            }
            $product->providers()->sync($providerIds);
        }

        if (!empty($data['tags'])) {
            $tagIds = [];
            foreach ($data['tags'] as $tag) {
                $tagIds[] = $tag['id'];
            }
            $product->tags()->sync($tagIds);
        }

        return redirect()->route('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy($id)
    {
        Product::find($id)->update([
            'status' => false
        ]);
        return redirect()->route('products.index');
    }
}
