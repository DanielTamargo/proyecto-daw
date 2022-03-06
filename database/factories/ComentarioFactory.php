<?php

namespace Database\Factories;

use App\Models\Constants;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'texto' => $this->faker->realTextBetween(20, 200),
        ];
    }
}
