<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosPedido extends Model
{
    use HasFactory;
    
    // Deshabilitamos los timestamps (optimizando la BBDD)
    public $timestamps = false;

    // Permite guardar las variables indicadas
    protected $fillable = [
        'pedido_id', 
        'producto_id', 
    ];
}
