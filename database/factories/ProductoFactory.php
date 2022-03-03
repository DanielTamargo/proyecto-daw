<?php

namespace Database\Factories;

use App\Models\Constants;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
        $admins = User::where('rol', Constants::ROL_ADMINISTRADOR)->get();

        // Requiere recibir de un valor creado_por, que será el id de algún administrador
        return [
            'nombre' => ucfirst($this->faker->words(rand(3, 5), true)),
            'descripcion' => $this->faker->realTextBetween(),
            'precio' => $this->faker->randomFloat(2, 2, 80),
            'foto' => 'placeholder_' . rand(1, 6) . '.png',
            'creado_por' => $admins[rand(0, count($admins) - 1)]->id,
        ];
    }
}
