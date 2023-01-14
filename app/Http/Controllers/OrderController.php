<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Store;
use App\Models\StoreProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Orders/Index');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        return Inertia::render('Orders/Create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'store' => ['required'],
            'provider' => ['required'],
            'products' => ['required'],
        ])->validate();

        $data = $request->all();

        $order = Order::create([
            'date' => now(),
            'type' => 1,
            'status' => 1,
            'user_id' => Auth()->user()->id,
            'provider_id' => $data['provider']['id'],
            'store_id' => $data['store']['id'],
        ]);

        foreach ($data['products'] as $product) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'unid' => $product['unit'],
                'price' => $product['price']
            ]);
        }

        Session::flash('message', 'Se creó la orden de compra de manera exitosa.');
        return response()->json([
            'status' => 'success',
            'url' => route('orders.index'),
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function edit(Order $order)
    {
        return Inertia::render('Orders/Edit', [
            'order' => $order,
            'provider' => $order->provider,
            'user' => $order->user,
            'store' => $order->store,
            'products' => $order->listproducts(),
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
            'status' => ['required'],
        ])->validate();

        $data = $request->all();
        $order = Order::find($id);

        if ($order->status >= 3) {
            Session::flash('error', 'La orden no puede ser actualizada.');
            return response()->json([
                'status' => 'error',
                'url' => route('orders.index'),
            ]);
        }
        if ($order->status == 1 && $data['status'] == 2) {
            $order->status = $data['status'];
            $order->save();
            Session::flash('message', 'La orden se ha iniciado correctamente.');
            return response()->json([
                'status' => 'success',
                'url' => route('orders.index'),
            ]);
        }
        if ($order->status == 2 && $data['status'] == 3) {
            $productsStore = Store::find($order->store_id)->products;
            $productsOrder = OrderProduct::where('order_id', $order->id)->get();

            foreach ($productsOrder as $prod1) {
                $exist = false;
                foreach ($productsStore as $prod2) {
                    if ($prod1->product_id == $prod2->product_id) {
                        $prod1->unid += $prod2->unid;
                        StoreProduct::where('store_id', $order->store_id)
                                    ->where('product_id', $prod1->product_id)
                                    ->update(['unid' => $prod1->unid]);
                        $exist = true;
                    }
                }
                if (!$exist) {
                    StoreProduct::create([
                        'store_id' => $order->store->id,
                        'product_id' => $prod1->product_id,
                        'unid' => $prod1->unid
                    ]);
                }
            }

            $order->status = $data['status'];
            $order->save();
            Session::flash('message', 'La orden se ha completado correctamente.');
            return response()->json([
                'status' => 'success',
                'url' => route('orders.index'),
            ]);
        }
        if ($data['status'] == 5 || $data['status'] == 4) {
            $order->status = $data['status'];
            $order->save();
            Session::flash('message', 'La orden se ha cancelado correctamente.');
            return response()->json([
                'status' => 'success',
                'url' => route('orders.index'),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy($id)
    {
        Order::find($id)->update([
            'status' => false
        ]);
        return redirect()->route('orders.index');
    }
}
