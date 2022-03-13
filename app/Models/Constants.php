<?php

namespace App\Models;

use DateTime;

class Constants
{
    /**
     * Las enumeraciones dieron ciertos problemas en el proyecto pasado, por lo que vamos a optar
     * por otra solución.
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

    // Cuenta a la que enviar siempre el email para no spamear emails a cuentas ya existentes o enviar emails a cuentas que no existen
    const EMAIL_DESTINATARIO = 'daniel.tamargo@ikasle.egibide.org';

    /**
     * @param DateTime $start fecha mínima
     * @param DateTime $end fecha máxima
     * @return DateTime devuelve el timestamp obtenido aleatoriamente entre ambas fechas
     */
    public static function randomTimestampEntreFechas(DateTime $start, DateTime $end) {
        $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
        $randomDate = new DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        return $randomDate;
    }
}
