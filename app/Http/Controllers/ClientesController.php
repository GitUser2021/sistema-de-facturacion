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
            return view('clientes/vista_clientes',['clientes'=>$clientes]);
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
        return view('clientes/form_nuevo_cliente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        'nombre' => 'required|max:30',
        'telefono' => 'required|max:20',
        'direccion' => 'required|max:30',
        'email' => 'required|max:30',
    ]);

        $cliente = new Cliente;
        $cliente->Nombre =  $request->nombre;
        $cliente->Telefono =  $request->telefono;
        $cliente->Email =  $request->email;
        $cliente->Direccion =  $request->direccion;
        $cliente->Estado =  $request->estado;
        $cliente->save();
        return redirect('nuevo_cliente')->with('mensaje', 'Cliente agregado correctamente');
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

        $titulo = $request->titulo;
        $nombre = $request->nombre;
        $vendedores = Vendedor::get();
        $productos = Producto::get();
//        $nombre = $request->cliente;
        $cliente = Cliente::where('Nombre',$nombre)->firstOr(function (){
            $cliente = new \stdClass();
            $cliente->Nombre = 'no encontrado!';
            $cliente->id_cliente = 'xx';
            return $cliente;
        });
        return json_encode($cliente);
//        return view('facturas/form_nueva_factura',['cliente'=>$cliente,'vendedores'=>$vendedores,'productos'=>$productos,'id'=>$id])->with('titulo',$titulo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $cliente = Cliente::find($id);
        $editar = 'editar';
        return view('clientes/form_nuevo_cliente',['cliente'=>$cliente,'editar'=>$editar,'id'=>$id]);

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
        $request->validate([
            'nombre' => 'required|max:30',
            'telefono' => 'required|max:20',
            'direccion' => 'required|max:30',
            'email' => 'required|max:30',
        ]);

        $nombre = $request->nombre;
        $telefono = $request->telefono;
        $email = $request->email;
        $direccion = $request->direccion;
        $estado = $request->estado;

        try {
            $cliente = Cliente::find($id);
            $cliente->Nombre = $nombre;
            $cliente->Telefono = $telefono;
            $cliente->Email = $email;
            $cliente->Direccion = $direccion;
            $cliente->Estado = $estado;

            $cliente->save();

            return redirect('lista_clientes')->with('mensaje','Cliente actualizado correctamente.');

        }catch (\Throwable $error){
          echo $error->getMessage() ;
        };

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cliente::find($id)->delete();
        return redirect('lista_clientes');
    }
}
