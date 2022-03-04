<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasProducto extends Model
{
    use HasFactory;

    // Deshabilitamos los timestamps (optimizando la BBDD)
    public $timestamps = false;
    
    // Permite guardar las variables indicadas
    protected $fillable = [
        'producto_id', 
        'categoria_id', 
    ];
}
