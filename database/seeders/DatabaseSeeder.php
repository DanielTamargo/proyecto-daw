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
        // Variables control seeder
        $clientes_min = 10;
        $clientes_max = 20;

        $productos_min = 50;
        $productos_max = 100;

        $fecha_min = new DateTime('2000-01-01');
        $fecha_max = new DateTime();

        $categoria_probabilidad = 25;

        $pedidos_min = 20;
        $pedidos_max = 40;

        $pedido_probabilidad_cancelado = 10;

        $productos_pedido_min = 1;
        $productos_pedido_max = 8;


        // Seeder
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
        $productos = Producto::factory(rand($productos_min, $productos_max))
            ->create(['fecha_publicacion' => Constants::randomTimestampEntreFechas($fecha_min, $fecha_max)]);

        // Creamos categorías productos (utilizando el pivot)
        $maxId = Categoria::all()->last()->id;
        foreach ($productos as $producto) {
            foreach (range(1, $maxId) as $num) {
                if (rand(0, 100) < $categoria_probabilidad) CategoriasProducto::create(['producto_id' => $producto->id, 'categoria_id' => $num]);
            }
        }

        // Creamos pedidos
        for ($i = 0; $i < 1; $i++) {
            $fecha_pedido = Constants::randomTimestampEntreFechas($fecha_min, $fecha_max);
            $productos_disponibles = Producto::where('fecha_publicacion', '<', $fecha_pedido)->get();

            // TODO comprobar clientes disponibles, o registrar todos los clientes a una fecha anterior, o dejarlo así

            // Si por fecha no encuentra productos que estuvieran disponibles, repite
            if (count($productos_disponibles) <= 0) {
                $i--;
                continue;
            }

            // Creamos el pedido
            $pedido = Pedido::create([
                'cliente_id' => $clientes[rand(0, count($clientes) - 1)]->id,
                'estado' => rand(0, 100) > $pedido_probabilidad_cancelado ? Constants::ESTADO_ENTREGADO : Constants::ESTADO_CANCELADO,
                'fecha_pedido' => $fecha_pedido
            ]);

            // Asociamos productos
            // De entre los productos disponibles, añade una serie de productos aleatoriamente al pedido
            $num_productos_pedido = rand($productos_pedido_min, $productos_pedido_max);
            for ($j = 0; $j < $num_productos_pedido; $j++) {
                ProductosPedido::create([
                    'producto_id' => $productos[rand(0, count($productos) - 1)]->id,
                    'pedido_id' => $pedido->id
                ]);
            }
        }

        // Creamos pedidos pendientes
        // TODO

    }
}
