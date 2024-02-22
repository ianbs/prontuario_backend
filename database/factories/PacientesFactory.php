<?php

namespace Database\Factories;

use App\Models\Pacientes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pacientes>
 */
class PacientesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pacientes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'cpf' => $this->faker->unique()->shuffleString('12345678912'),
            'data_nascimento' => $this->faker->date,
            'telefone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }

    // /**
    //  * Indicate that the model should be soft deleted.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Factories\Factory
    //  */
    // public function softDeleted()
    // {
    //     return $this->state(function (array $attributes) {
    //         return [
    //             'deleted_at' => now()->subDays(rand(1, 100)),
    //         ];
    //     });
    // }
}
