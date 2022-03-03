<?php

namespace App\Models;

class Constants
{
    /**
     * Las enumeraciones dieron ciertos problemas en el proyecto pasado, por lo que vamos a optar
     * por otra solución.
     * 
     * 
     * Para fomentar unas buenas prácticas usaremos constantes como enumeraciones con unos valores fijos
     * en lugar de hardcodear los valores cuando se necesiten (pudiendo provocar el clásico 'muñoneo')
     */


    // EstadosPedidos
    const ESTADO_RECIBIDO  = 'recibido';
    const ESTADO_ENPROCESO = 'enproceso';
    const ESTADO_LISTO     = 'listo';
    const ESTADO_ENTREGADO = 'entregado';
    const ESTADO_CANCELADO = 'cancelado';


    // RolesUsuarios
    const ROL_ADMINISTRADOR = 'administrador';
    const ROL_CLIENTE       = 'cliente';


    // CategoriasProductos
    const CATEGORIAPRODUCTO_ENTRANTE = 'entrante';
    const CATEGORIAPRODUCTO_PRIMERO  = 'primero';
    const CATEGORIAPRODUCTO_SEGUNDO  = 'segundo';
    const CATEGORIAPRODUCTO_POSTRE   = 'postre';
    const CATEGORIAPRODUCTO_BEBIDA   = 'bebida';

    const CATEGORIAPRODUCTO_SINGLUTEN   = 'singluten';
    const CATEGORIAPRODUCTO_VEGANO      = 'vegano';
    const CATEGORIAPRODUCTO_VEGETARIANO = 'vegetariano';
    const CATEGORIAPRODUCTO_CARNE       = 'carne';
    const CATEGORIAPRODUCTO_PESCADO     = 'pescado';
    
    const CATEGORIAPRODUCTO_REFRESCO = 'refresco';
    const CATEGORIAPRODUCTO_VINO     = 'vino';
}
