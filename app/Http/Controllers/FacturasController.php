<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Vendedor;
use App\Factura;
use App\Producto;
use App\Detalle_factura;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class FacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        session_start();
        define('PAGE', 5);

        $input = $request->input;
        $_SESSION['param'] = $input;

        if ($input == '' || $input == 'all') {
            $facturas = Factura::paginate(PAGE);
            $_SESSION['clientes'] = Cliente::get();
            $_SESSION['vendedores'] = Vendedor::get();
            return view('facturas/vista_facturas', ['facturas' => $facturas]);
        }
        if (is_numeric($input)) {
            $facturas = Factura::where('id_factura', 'like', $input . '%')->paginate(PAGE);
            return view('facturas/vista_facturas', ['facturas' => $facturas]);
        }
        if (is_string($input)) {
            $clientes = Cliente::where('Nombre', 'like', $input . '%')->get();
            $id_clientes = [];
            foreach ($clientes as $cliente) {
                array_push($id_clientes, $cliente->id_cliente);
            }
            $facturas = Factura::whereIn('id_cliente', $id_clientes)->paginate(PAGE);
            return view('facturas/vista_facturas', ['facturas' => $facturas]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::get();
        $vendedores = Vendedor::get();
        $detalle_facturas = Detalle_factura::get();
        $productos = Producto::get();
        return view('facturas/form_nueva_factura', ['clientes' => $clientes, 'vendedores' => $vendedores, 'detalle_facturas' => $detalle_facturas, 'productos' => $productos])->with('titulo', 'NUEVA');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carrito = json_decode($request->carrito);
        $id_cliente = $request->id_cliente;
        $id_vendedor = $request->vende;
        $total_factura = $request->total_factura;
        $factura = new Factura;
        $factura->id_cliente = $id_cliente;
        $factura->id_vendedor = $id_vendedor;
        $factura->total_venta = $total_factura;
        $factura->estado = 'pendiente';
        $factura->save();
        $id_factura = $factura->id_factura;
        foreach ($carrito as $key => $carrito) {
            $detalle_factura = new Detalle_factura;
            $detalle_factura->id_factura = $id_factura;
            $detalle_factura->id_producto = $carrito->codigo;
            $detalle_factura->cantidad = $carrito->cantidad;
            $detalle_factura->precio_venta = $carrito->precio;
            $detalle_factura->save();
        }
        return redirect('facturas');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $factura = Detalle_factura::where('id_factura', $id)->get();
        } else {
            $factura = $request->imprimir_factura;
        }
        return view('plantillas/pdf', ['facturas/factura' => $factura]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Factura::find($id)->delete();
            Detalle_factura::whereIn('id_factura', [$id])->delete();
            return redirect('facturas')->with('mensaje', 'Factura: eliminada correctamente.');
//            throw new \Exception('Some Error Message');
        } catch (\Throwable $exception) {
            echo 'Error:->' . $exception->getMessage();
        }
    }
}
