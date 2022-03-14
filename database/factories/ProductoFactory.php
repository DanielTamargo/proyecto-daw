<?php

namespace Database\Factories;

use App\Models\Constants;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $fecha_min = new DateTime('2000-01-01');
        $fecha_max = new DateTime();

        $admins = User::where('rol', Constants::ROL_ADMINISTRADOR)->get();

        $numPlaceholder = rand(1, 8);
        switch($numPlaceholder) {
            case 2:
                $nombre = 'Tortilla';
                break;
            case 3:
                $nombre = 'Salmón';
                break;
            case 4:
                $nombre = 'Crema de espárragos';
                break;
            case 5:
                $nombre = 'Solomillo';
                break;
            case 6:
                $nombre = 'Tarta';
                break;
            case 7:
                $nombre = 'Pulpo';
                break;
            case 8:
                $nombre = 'Spaguetti a la';
                break;
            default:
                $nombre = 'Hamburguesa';
        }

        // Requiere recibir de un valor creado_por, que será el id de algún administrador
        return [
            'nombre' => $nombre . ' ' . $this->faker->words(rand(1, 3), true),
            'descripcion' => $this->faker->realTextBetween(),
            'precio' => $this->faker->randomFloat(2, 2, 20),
            'foto' => 'placeholder_' . $numPlaceholder . '.png',
            'creado_por' => $admins[rand(0, count($admins) - 1)]->id,
            'fecha_publicacion' => Constants::randomTimestampEntreFechas($fecha_min, $fecha_max),
        ];
    }
}
