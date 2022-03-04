<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\CategoriasProducto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Constants;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\ProductosPedido;
use App\Models\User;
use DateTime;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // VARIABLES CONTROL SEEDER

        /* -- CLIENTES -- */
        $clientes_min = 10;
        $clientes_max = 20;

        /* -- PRODUCTOS -- */
        $productos_min = 50;
        $productos_max = 100;
        // Fecha publicación productos está configurado en ProductoFactory.php
        $categoria_probabilidad = 25;

        /* -- PEDIDOS -- */
        $fecha_min = new DateTime('2005-01-01');
        $fecha_max = new DateTime();

        $pedidos_min = 20;
        $pedidos_max = 40;
        $pedido_probabilidad_cancelado = 10;

        $productos_pedido_min = 1;
        $productos_pedido_max = 8;

        /* -- PEDIDOS PENDIENTES -- */
        $pedidos_pdtes_min = 2;
        $pedidos_pdtes_max = 4;

        $productos_pedido_pdte_min = 1;
        $productos_pedido_pdte_max = 8;

        
        // COMIENZA EL SEEDER
        $this->command->warn("Starting Seeding. ");


        // Creamos dos administradores
        $dani = User::create([
            'email' => 'daniel.tamargo@ikasle.egibide.org',
            'username' => 'dani',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'rol' => Constants::ROL_ADMINISTRADOR,
            'dni' => '72831820C',
            'nombre' => 'Daniel Tamargo',
            'telefono' => '+34 648 703 215',
            'direccion' => 'C/Ori 18, 01010',
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ]);
        $raul = User::create([
            'email' => 'raul.melgosa@ikasle.egibide.org',
            'username' => 'raul',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'rol' => Constants::ROL_ADMINISTRADOR,
            'dni' => '95495990J',
            'nombre' => 'Raúl Melgosa',
            'telefono' => '+34 623 892 920',
            'direccion' => 'C/Colón 20, 09200',
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ]);


        // Creamos clientes
        $clientes = User::factory(rand($clientes_min, $clientes_max))->create();
        // Cambiamos la fecha de creación y actualización del cliente (para simular que se registraron a través de los años)
        foreach ($clientes as $cliente) {
            $fecha_random = Constants::randomTimestampEntreFechas($fecha_min, $fecha_max);
            $cliente->created_at = $fecha_random;
            $cliente->updated_at = $fecha_random;
            $cliente->save();
        }


        // Creamos categorías (hardcodeadas, serán categorías fijas)
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_ENTRANTE]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_PRIMERO]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_SEGUNDO]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_POSTRE]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_BEBIDA]);

        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_VEGANO]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_VEGETARIANO]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_SINGLUTEN]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_CARNE]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_PESCADO]);
        
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_REFRESCO]);
        Categoria::create(['nombre' => Constants::CATEGORIAPRODUCTO_VINO]);


        // Creamos productos
        $productos = Producto::factory(rand($productos_min, $productos_max))->create();


        // Creamos categorías productos (utilizando el pivot)
        $maxId = Categoria::all()->last()->id;
        foreach ($productos as $producto) {
            foreach (range(1, $maxId) as $num) {
                if (rand(0, 100) < $categoria_probabilidad) CategoriasProducto::create(['producto_id' => $producto->id, 'categoria_id' => $num]);
            }
        }


        // Creamos pedidos
        for ($i = 0; $i < rand($pedidos_min, $pedidos_max); $i++) {
            $fecha_pedido = Constants::randomTimestampEntreFechas($fecha_min, $fecha_max);

            // Comprobamos que, en base a la fecha a utilizar para el pedido, ya existían productos publicados y clientes registrados
            $productos_disponibles = Producto::where('fecha_publicacion', '<', $fecha_pedido)->get();
            $clientes_disponibles = User::where('created_at', '<', $fecha_pedido)->where('rol', Constants::ROL_CLIENTE)->get();

            // Si por fecha no encuentra productos que estuvieran disponibles, repite
            if (count($productos_disponibles) <= 0 || count($clientes_disponibles) <= 0) {
                $i--;
                continue;
            }

            // Creamos el pedido
            $pedido = Pedido::create([
                'cliente_id' => $clientes_disponibles[rand(0, count($clientes_disponibles) - 1)]->id,
                'estado' => rand(0, 100) > $pedido_probabilidad_cancelado ? Constants::ESTADO_ENTREGADO : Constants::ESTADO_CANCELADO,
                'fecha_pedido' => $fecha_pedido
            ]);

            // Asociamos productos
            // De entre los productos disponibles, añade una serie de productos aleatoriamente al pedido
            $num_productos_pedido = rand($productos_pedido_min, $productos_pedido_max);
            for ($j = 0; $j < $num_productos_pedido; $j++) {
                ProductosPedido::create([
                    'producto_id' => $productos_disponibles[rand(0, count($productos_disponibles) - 1)]->id,
                    'pedido_id' => $pedido->id
                ]);
            }

            // Actualizamos timestamps
            $pedido->created_at = $fecha_pedido;
            $pedido->updated_at = $fecha_pedido;
            $pedido->save();
        }
        
        // Creamos pedidos pendientes
        for ($i = 0; $i < rand($pedidos_pdtes_min, $pedidos_pdtes_max); $i++) {
            // Creamos el pedido
            $pedido = Pedido::create([
                'cliente_id' => $clientes_disponibles[rand(0, count($clientes_disponibles) - 1)]->id,
                'estado' => rand(0, 100) > $pedido_probabilidad_cancelado ? Constants::ESTADO_ENTREGADO : Constants::ESTADO_CANCELADO,
                'fecha_pedido' => $fecha_pedido
            ]);

            // Asociamos productos
            $num_productos_pedido = rand($productos_pedido_pdte_min, $productos_pedido_pdte_max);
            for ($j = 0; $j < $num_productos_pedido; $j++) {
                ProductosPedido::create([
                    'producto_id' => $productos[rand(0, count($productos) - 1)]->id,
                    'pedido_id' => $pedido->id
                ]);
            }
        }

    }
}
