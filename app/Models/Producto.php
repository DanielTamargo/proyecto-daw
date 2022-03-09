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
        return $this->hasMany(Comentario::class);
    }

    /**
     * Devuelve cuántas veces está añadido el producto en el carrito del cliente
     */
    public function cantidadEnCarrito($cliente)
    {
        return count(ProductosCarrito::where('producto_id', $this->id)->where('cliente_id', $cliente->id)->get());
    }
}
