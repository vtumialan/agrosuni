<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Transfer;
use App\Models\TransferProduct;
use App\Models\Store;
use App\Models\StoreProduct;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class TransferController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Transfers/Index');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create()
    {
        return Inertia::render('Transfers/Create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'origin_store' => ['required'],
            'destination_store' => ['required'],
            'products' => ['required'],
        ])->validate();

        $data = $request->all();

        $transfer = Transfer::create([
            'created_date' => now(),
            'status' => 0,
            'user_id' => Auth()->user()->id,
            'origin_store_id' => $data['origin_store']['id'],
            'destination_store_id' => $data['destination_store']['id'],
        ]);

        foreach ($data['products'] as $product) {
            TransferProduct::create([
                'transfer_id' => $transfer->id,
                'product_id' => $product['id'],
                'unid' => $product['unit'],
            ]);
        }

        Session::flash('message', 'Se creó la orden de compra de manera exitosa.');
        return response()->json([
            'status' => 'success',
            'url' => route('transfers.index'),
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function edit(Transfer $transfer)
    {
        return Inertia::render('Transfers/Edit', [
            'transfer' => $transfer,
            'origin_store' => $transfer->origin_store,
            'destination_store' => $transfer->destination_store,
            'user_created' => $transfer->user_created,
            'user_completed' => $transfer->user_completed,
            'products' => $transfer->listproducts(),
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
        $transfer = Transfer::find($id);

        if ($transfer->status != 0) {
            Session::flash('error', 'La orden no puede ser actualizada.');
            return response()->json([
                'status' => 'error',
                'url' => route('transfers.index'),
            ]);
        }
        if ($data['status'] == 1) {
            $productsStoreOrigin = Store::find($transfer->origin_store_id)->products;
            $productsStoreDestination = Store::find($transfer->destination_store_id)->products;
            $productsTransfer = TransferProduct::where('transfer_id', $transfer->id)->get();

            foreach ($productsTransfer as $prod1) {
                $exist = false;
                foreach ($productsStoreOrigin as $prod2) {
                    if ($prod1->product_id == $prod2->product_id) {
                        $diff = $prod2->unid - $prod1->unid;
                        StoreProduct::where('store_id', $transfer->origin_store_id)
                                    ->where('product_id', $prod1->product_id)
                                    ->update(['unid' => $diff]);
                    }
                }
                foreach ($productsStoreDestination as $prod2) {
                    if ($prod1->product_id == $prod2->product_id) {
                        $sum = $prod2->unid + $prod1->unid;
                        StoreProduct::where('store_id', $transfer->destination_store_id)
                                    ->where('product_id', $prod1->product_id)
                                    ->update(['unid' => $sum]);
                        $exist = true;
                    }
                }
                if (!$exist) {
                    StoreProduct::create([
                        'store_id' => $transfer->destination_store_id,
                        'product_id' => $prod1->product_id,
                        'unid' => $prod1->unid
                    ]);
                }
            }

            $transfer->status = $data['status'];
            $transfer->user_completed_id = Auth()->user()->id;
            $transfer->completed_date =  now();
            $transfer->save();
            Session::flash('message', 'La orden se ha completado correctamente.');
            return response()->json([
                'status' => 'success',
                'url' => route('transfers.index'),
            ]);
        }
        if ($data['status'] == 2) {
            $transfer->status = $data['status'];
            $transfer->save();
            Session::flash('message', 'La orden se ha cancelado correctamente.');
            return response()->json([
                'status' => 'success',
                'url' => route('transfers.index'),
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
        Transfer::find($id)->update([
            'status' => false
        ]);
        return redirect()->route('transfers.index');
    }
}
