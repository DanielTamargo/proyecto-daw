<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    
    // Permite guardar las variables indicadas
    protected $fillable = [
        'texto', 
        'puntuacion', 
        'fecha_publicacion',
        'producto_id',
        'cliente_id',
    ];

    /**
     * Relación: One to Many
     * 
     * Devuelve el cliente que publicó el comentario
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id', 'id');
    }

    /**
     * Relación: One to Many
     * 
     * Devuelve el producto sobre el que se publicó el comentario
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
