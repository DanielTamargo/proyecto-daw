<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all()->sortByDesc('id');
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Crear producto
        $producto = new Producto();
        $producto->nombre = trim($request->nombre);
        $producto->descripcion = trim($request->descripcion);
        $producto->precio = number_format($request->precio, 2);
        $producto->creado_por = Auth::user()->id;
        $producto->save();

        // Almacenar la imagen
        try {
            $foto_nombre = 'producto-' . $producto->id . '.'. $request->foto->extension();
            $request->foto->move(public_path('img'), $foto_nombre);
            $producto->foto = $foto_nombre;
            $producto->save();
        } catch(\Exception $ex) {
            return back()->with('imposible_subir_foto', 'true');
        }

        // Redirigir
        return redirect()->route('inicio')->with('producto_creado', 'Producto creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $producto = Producto::find($request->id);
        return view('productos.show',compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return view('productos.create')->with('producto', Producto::find($request->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        // Obtener producto
        $producto = Producto::find($request->producto_id);

        if (!$producto) return back()->with('imposible_actualizar', 'Imposible actualizar, producto no encontrado...');

        // Editar producto
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;

        // Si ha subido una nueva foto, reemplazar
        if($request->hasFile('foto')) {
            try {
                // Almacenar la imagen
                $foto_nombre = 'producto-' . $producto->id . '.'. $request->foto->extension();
                $request->foto->move(public_path('img'), $foto_nombre);
                $producto->foto = $foto_nombre;
            } catch(\Exception $ex) {
                return back()->with('imposible_subir_foto', 'true');
            }
        }

        // Guardar cambios
        $producto->save();

        // Redirigir
        return redirect()->route('inicio')->with('producto_editado', 'Producto editado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
