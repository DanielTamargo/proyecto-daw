<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class ApiController extends Controller
{
    /**
     * API cuya respuesta devuelve si un valor es único
     * 
     * Recibe:
     * - clave: string, clave a comparar
     * - valor: string, valor a cotejar
     * 
     * Devuelve una respuesta json, valor_unico será true si no existe otro usuario con el mismo valor y false si sí que existe
     */
    public function comprobarUsuarioCampoUnico() {
        // Recibimos clave y valor
        $clave = $_GET["clave"];
        $valor = $_GET["valor"];

        $user = User::where($clave, $valor)->first();

        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida',
            'valor_unico' => $user ? false : true, // <- Aclaración: si el usuario NO existe, el valor único SÍ es true
        ], 200);
    }
}