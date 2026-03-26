<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function store(Request $request)
    {
        $orden = new Order();
        $orden->user_id = 1;
        $orden->metodo_pago = "Tarjeta";
        $orden->save();

        $productos = $request->product_id;
        $cantidades = $request->cantidad;
        $precios = $request->price;

        foreach ($productos as $key => $id) {
            $orden->products()->attach($id, [
                'cantidad' => $cantidades[$key],
                'price' => $precios[$key]
            ]);
        }

        return "Orden guardada con exito";
    }
}
