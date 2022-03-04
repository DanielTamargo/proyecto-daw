<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'nombre',
        'direccion',
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

}
