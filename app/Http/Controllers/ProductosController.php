<?php

namespace App\Http\Controllers;

use App\Cliente;
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
        define('PAGE', 5);
        session_start();
        $input = $request->input;
        $_SESSION['param'] = $input;

        if (is_numeric($input)) {
            $productos = Producto::where('Codigo', 'like', $input . '%')->paginate(PAGE);
            return view('productos/vista_productos', ['productos' => $productos]);
        }
        if (!isset($input)) {
            $productos = Producto::paginate(PAGE);
            return view('productos/vista_productos', ['productos' => $productos]);
        } else
            if ($input == 'all') {
                $productos = Producto::paginate(PAGE);
                return view('productos/vista_productos', ['productos' => $productos]);
            } else {
                $productos = Producto::where('Producto', 'like', $input . '%')->paginate(PAGE);
                return view('productos/vista_productos', ['productos' => $productos]);
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productos/form_nuevo_producto');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|max:13',
            'producto' => 'required|max:30',
            'precio' => 'required|max:10',
        ]);

        $producto = new Producto;
        $producto->Codigo = $request->codigo;
        $producto->Producto = $request->producto;
        $producto->Precio = $request->precio;
        $producto->Estado = $request->estado;
        $producto->save();
        return redirect('nuevo_producto')->with('mensaje', 'Producto agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editar = 'editar';
        $producto = Producto::find($id);

        return view('productos/form_nuevo_producto', ['producto' => $producto, 'id' => $id, 'editar' => $editar]);


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
        $request->validate([
            'codigo' => 'required|max:13',
            'producto' => 'required|max:30',
            'precio' => 'required|max:10',
        ]);

        $codigo = $request->codigo;
        $nombre_producto = $request->producto;
        $estado = $request->estado;
        $precio = $request->precio;

        $producto = Producto::find($id);
        $producto->Codigo = $codigo;
        $producto->Producto = $nombre_producto;
        $producto->Estado = $estado;
        $producto->Precio = $precio;
        $producto->save();
        return redirect('lista_productos')->with('mensaje', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Producto::where('Codigo', $id)->delete();
        return redirect('lista_productos');

    }
}
