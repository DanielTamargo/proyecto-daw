<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    
    // Permite guardar las variables indicadas
    protected $fillable = [
        'estado', 
        'fecha_pedido', 
        'cliente_id', 
    ];

    /**
     * Relación: One to Many
     * 
     * Devuelve el cliente que realizó el pedido
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id', 'id');
    }

    /**
     * Relación: One to Many
     * 
     * Devuelve los productos asociados al pedido
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'productos_pedidos', 'pedido_id', 'producto_id');
    }
}
