<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    
    // Permite guardar las variables indicadas
    protected $fillable = [
        'nombre', 
        'descripcion', 
        'precio',
        'foto',
        'fecha_publicacion',
        'creado_por',
    ];

    /**
     * Relación: Many to Many
     * 
     * Devuelve las categorías del producto
     * Como pivot utilizará la tabla intermedia categorias_productos
    */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categorias_productos', 'producto_id', 'categoria_id');
    }

    /**
     * Relación: One to Many
     * 
     * Devuelve el usuario administrador que ha creado el producto
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por', 'id');
    }

    /**
     * Relación: One to Many
     * 
     * Devuelve los comentarios realizados sobre el producto
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class)->orderByDesc('id');
    }

    /**
     * Devuelve la cantidad del producto en el carrito
     * 
     * Recibe el cliente loggeado, si es null devolverá un 0
     * Devuelve un número entero con el resultado
     */
    public function cantidadEnCarrito($cliente)
    {
        if(!$cliente) return 0;
        $productoCarrito = ProductosCarrito::where('producto_id', $this->id)->where('cliente_id', $cliente->id)->first();

        if ($productoCarrito) 
            return $productoCarrito->cantidad;
        else
            return 0;
    }

    /**
     * Devuelve la cantidad del producto en el pedido
     * 
     * Recibe el pedido, si es null devolverá un 0
     * Devuelve un número entero con el resultado
     */
    public function cantidadEnPedido($pedido)
    {
        if(!$pedido) return 0;
        $productoPedido = ProductosPedido::where('pedido_id', $pedido->id)->where('producto_id', $this->id)->first();

        if ($productoPedido) 
            return $productoPedido->cantidad;
        else
            return 0;
    }
}
