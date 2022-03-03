<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    
    // Permite guardar las variables indicadas
    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación: Many to Many
     * 
     * Devuelve los productos que tengan dicha categoría
     * Como pivot utilizará la tabla intermedia categorias_productos
    */
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'categorias_productos', 'categoria_id', 'producto_id');
    }
}
