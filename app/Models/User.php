<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Permite guardar las variables indicadas
    protected $fillable = [
        'email',
        'username',
        'password',
        'rol',
        'dni',
        'nombre',
        'direccion',
        'telefono',
    ];

    // Atributos que deberían ser ocultos en la serialización
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Atributos que deberían tener un cast
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación: One to Many
     * 
     * Devuelve los pedidos del cliente
    */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'cliente_id', 'id');
    }

    /**
     * Relación: One to Many
     * 
     * Devuelve los comentarios del cliente
    */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'cliente_id', 'id');
    }

    /**
     * Relación: One to Many
     * 
     * Devuelve los productos añadidos al carrito del cliente
    */
    public function productosCarrito()
    {
        return $this->belongsToMany(Producto::class, 'productos_carritos', 'cliente_id', 'producto_id');
    }

    /**
     * Relación: One to Many
     * 
     * Devuelve los productos creados por el administrador
    */
    public function productosCreados()
    {
        return $this->hasMany(Producto::class, 'creado_por', 'id');
    }

    /**
     * Devuelve el número de productos que tiene en el carrito
     */
    public function cantidadProductosEnCarrito() 
    {
        $cantidad = 0;
        $productosCarrito = ProductosCarrito::where('cliente_id', $this->id)->get();
        
        foreach ($productosCarrito as $productoCarrito) {
            $cantidad += $productoCarrito->cantidad;
        }

        return $cantidad;
    }

    /**
     * Recibe un id de producto y devuelve true si en algún momento lo ha comprado
     */
    public function compraVerificada($producto_id) {
        $result = DB::table('productos_pedidos')
            ->join('pedidos', 'productos_pedidos.pedido_id', '=', 'pedidos.id')
            ->join('users', 'pedidos.cliente_id', '=', 'users.id')
            ->where('productos_pedidos.producto_id', $producto_id)
            ->where('pedidos.cliente_id', $this->id)
            ->select('productos_pedidos.id')
            ->count();
        return $result > 0;
    }

}
