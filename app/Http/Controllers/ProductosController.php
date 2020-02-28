<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $p = $request->p;
        $cod = $request->codigo;
        if($cod){
            $productos = Producto::where('Codigo','like', $cod.'%')->get();
            return json_encode($productos);
        }
        if (!isset($p) ) {
            $productos = Producto::get();
            return view('vista_productos',['productos'=>$productos]);
        }else
            if($p == 'all'){
            $productos = Producto::get();
            return json_encode($productos);
        }else{
            $productos = Producto::where('Producto','like', $p.'%')->get();
            return json_encode($productos);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form_nuevo_producto');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producto = new Producto;
        $producto->Codigo = $request->codigo;
        $producto->Producto = $request->producto;
        $producto->Precio = $request->precio;
        $producto->save();
        redirect('vista_productos');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
