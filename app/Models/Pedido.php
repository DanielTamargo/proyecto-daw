<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * Devuelve el precio total del pedido
     */
    public function precioTotal()
    {
        try {
            $total = array_sum(array_column(DB::table('productos_pedidos')
                ->join('productos', 'productos_pedidos.producto_id', '=', 'productos.id')
                ->where('productos_pedidos.pedido_id', $this->id)
                ->selectRaw('SUM(productos.precio * productos_pedidos.cantidad) AS total')
                ->get()
                ->toArray(), 'total'));
        } catch(\Exception $e) {
            $total = 0;
        }
        
        return $total;
    }
}
