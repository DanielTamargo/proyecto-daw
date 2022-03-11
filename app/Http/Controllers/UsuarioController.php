<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $usuario = User::find($request->id);
        if (!$usuario) return view('errors.404');

        return view('usuarios.show')->with('user', $usuario);
    }

    /**
     * Muestra el perfil del usuario
     */
    public function profile() {
        return view('usuarios.show')->with('user', Auth::user());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $usuario = User::find($request->user_id);
        
        // Eliminamos el usuario
        $usuario->delete();

        // Si un usuario elimina su propia cuenta, cerramos la sesión y redirigimos
        if ($usuario->id == Auth::user()->id) {
            Session::flush();
            Auth::logout();
            return redirect()->route('login'); 
        }

        // Volvemos a la vista
        return back()->with('usuario_eliminado', 'true');
    }
}
