<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Producto;
use App\Vendedor;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->name;
        $id = $request->id;
        if(isset($id)){
            $clientes = Cliente::where('id_cliente','like', $id.'%')->get();
            return json_encode($clientes);
        }
        if (!isset($name) ) {
            $clientes = Cliente::get();
            return view('vista_clientes',['clientes'=>$clientes]);
        }elseif($name == 'all'){
            $clientes = Cliente::get();
            return json_encode($clientes);
        }else{
            $clientes = Cliente::where('Nombre','like', $name.'%')->get();
            return json_encode($clientes);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form_nuevo_cliente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Cliente;
        $cliente->Nombre =  $request->nom;
        $cliente->Telefono =  $request->tel;
        $cliente->Email =  $request->email;
        $cliente->Direccion =  $request->dire;
        $cliente->save();
        echo 'cliente agregado';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
    public function show(Request $request)
    {

        $vendedores = Vendedor::get();
        $productos = Producto::get();
        $nombre = $request->cliente;
        $cliente = Cliente::where('Nombre',$nombre)->firstOr(function (){
            $cliente = new \stdClass();
            $cliente->Nombre = 'Cliente no encontrado!';
            $cliente->id_cliente = '';
            return $cliente;
        });
        return view('form_nueva_factura',['cliente'=>$cliente,'vendedores'=>$vendedores,'productos'=>$productos]);
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
