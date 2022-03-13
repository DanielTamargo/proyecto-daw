<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ComentarioController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validamos los datos
        $validator = Validator::make($request->all(), [
            'texto' => 'required|string|max:255|min:8',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Creamos el comentario
        Comentario::create([
            'cliente_id' => Auth::user()->id, 
            'producto_id' => $request->producto_id, 
            'texto' => $request->texto, 
            'puntuacion' => 4]);

        return back()
            ->with('toast_success', 'Comentario creado con éxito');
    }
}
