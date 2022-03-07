<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Registra un nuevo empleado
     */
    protected function store(Request $request)
    {
        // Validamos los datos
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol' => 'required|string|max:255',
            'dni' => 'required|string|min:9|max:12|unique:users',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:25',
            'direccion' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->with('registro', 'true')
                    ->withInput();
        }


        // Creamos el nuevo usuario
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'nombre' => $request->nombre,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);


        // Enviamos email al nuevo usuario
        /*
        $detalles = [
            'asunto' => 'Usuario Registrado',
            'rol_destinatario' => 'nuevo-empleado',
            'nombre' => $request->nombre,
            'usuario' => $request->email,
            'password' => $request->password
        ];
        */

        // TODO enviar email


        // Redirigimos a la ventana de inicio
        return redirect()->route('inicio', ['usuario_creado' => true]);
    }
}
