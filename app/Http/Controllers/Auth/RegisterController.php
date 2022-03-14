<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Constants;
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
            'dni' => 'required|string|min:9|max:12|unique:users',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:25',
            'direccion' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->with('registrar_usuario', 'true')
                ->withErrors($validator)
                ->withInput();
        }


        // Creamos el nuevo usuario
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'nombre' => $request->nombre,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'dni' => strtoupper($request->dni),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);


        // Enviamos email al nuevo usuario
        $details = [
            'asunto' => '¡Bienvenido/a a Hostelería DAW!',
            'plantilla_email' => 'emails.nuevo-usuario',
            'rol' => $user->rol,
            'nombre' => $user->nombre,
            'usuario' => $user->username,
            'password' => $request->password //<- sin encriptar para los nuevos admins que son registrados por otros admins
        ];
       
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\HosteleriaMail($details));
        } catch (\Exception $e) {}

        // Loggeamos al nuevo usuario si no es un administrador que crea otro administrador
        if (!Auth::user()) Auth::login($user);

        
        // Redirigimos a la ventana de inicio
        return redirect()->route('inicio')->with('toast_success', 'Registro realizado con éxito');
    }

    /**
     * Carga la vista login/registro deslizando directamente al formulario registro
     */
    public function load() 
    {
        // Si es un usuario loggeado que no es administrador, no podrá registrarse/loggearse sin hacer logout primero
        if (Auth::user() && Auth::user()->rol != Constants::ROL_ADMINISTRADOR) return redirect()->route('inicio');

        return view('auth.login')->with('registrar_usuario', 'true'); 
    }
}
