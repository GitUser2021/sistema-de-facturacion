<?php

namespace App\Http\Controllers;

use App\Detalle_Factura;
use App\Factura;
use App\Producto;
use App\Cliente;
use App\Vendedor;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Detalle_FacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $factura_detalles = Detalle_Factura::where('id_factura',$id)->get();
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
        return view('productos/vista_agregar_productos_factura',['productos'=>$productos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detalle_factura = new Detalle_Factura;
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
        return view( 'plantillas/pdf',['factura'=>$datos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $productos = Producto::get();
            $detalle_facturas = Detalle_factura::where('id_factura',$id)->get();

            if( count($detalle_facturas) == 0  ){
                throw new \Exception('FACTURA N°'.$id.' NO ENCONTRADA!');
            }
        }catch (\Throwable $error){
            echo  '<h1 style="background: red;margin-top: 5px;font-weight: bold;">'. $error->getMessage() .'</h1>';
        }

        $carrito = [];
        foreach($detalle_facturas as $index => $detalle_factura){
                $carrito[$index]['codigo'] = $detalle_factura->id_producto;
                $carrito[$index]['cantidad'] = $detalle_factura->cantidad;
            try {
                $carrito[$index]['producto'] = DB::table('productos')->select('Producto')->where('Codigo',$detalle_factura->id_producto)->first()->Producto;
            }catch ( \Throwable $error){
                $carrito[$index]['producto'] = 'Producto no encontrado!';
            }
                $carrito[$index]['precio'] = $detalle_factura->precio_venta;
                $carrito[$index]['total'] = $detalle_factura->precio_venta * $detalle_factura->cantidad;
                $carrito[$index]['acciones'] = '';
        }
        $carrito = json_encode($carrito);
        $factura = Factura::find($id);
        $cliente = Cliente::find($factura->id_cliente);
        $vendedor_ = Vendedor::find($factura->id_vendedor);
        $clientes = Cliente::get();
        $vendedores =  Vendedor::get();

        return view('facturas/form_nueva_factura',['carrito'=>$carrito,'clientes'=>$clientes,'cliente'=>$cliente,'vendedores'=>$vendedores,'vendedor_'=>$vendedor_,'detalle_facturas'=>$detalle_facturas,'productos'=>$productos,'id'=>$id])->with('titulo','EDITAR');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $carrito = json_decode($request->carrito);
        $id_cliente = $request->id_cliente;
        $id_vendedor = $request->vende;
        $total_factura = $request->total_factura;

        $factura = Factura::find($id);
        $factura->id_cliente = $id_cliente;
        $factura->id_vendedor = $id_vendedor;
        $factura->total_venta = $total_factura;
        $factura->estado = 'pendiente';
        $factura->save();
        Detalle_factura::where('id_factura',$id)->delete();
        foreach ($carrito as $key => $carrito) {
            $detalle_factura = new Detalle_factura;
            $detalle_factura->id_factura = $id;
            $detalle_factura->id_producto = $carrito->codigo;
            $detalle_factura->cantidad = $carrito->cantidad;
            $detalle_factura->precio_venta = $carrito->precio;
            $detalle_factura->save();
        }
        return redirect('facturas');





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
