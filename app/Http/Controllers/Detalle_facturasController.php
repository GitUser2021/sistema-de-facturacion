<?php

namespace App\Http\Controllers;

use App\Detalle_factura;
use App\Factura;
use App\Producto;
use App\Cliente;
use App\Vendedor;
use Illuminate\Http\Request;
class Detalle_facturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $factura_detalles = Detalle_factura::where('id_factura',$id)->get();
        $factura = Factura::find($id);
        $productos = Producto::get();
        $clientes = Cliente::get();
        $vendedores = Vendedor::get();
        return json_encode([$factura_detalles,$factura,$productos,$clientes,$vendedores]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = Producto::get();
        return view('vista_agregar_productos_factura',['productos'=>$productos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detalle_factura = new Detalle_factura;
        $id_producto = $request->cod;
        $cantidad = $request->cant;
        $detalle_factura->id_factura = 112233;
        $detalle_factura->id_producto = $id_producto;
        $detalle_factura->cantidad = $cantidad;
        $detalle_factura->precio_venta = 99;
        $detalle_factura->save();
        echo('<script>history.go(-1)</script>');
        echo('<script>ref_div[0].classList.toggle("dis-block")</script>');
        echo('<script>console.log("toggle")</script>');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
            $datos = $request->datos;
        return view( 'pdf',['factura'=>$datos]);
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
