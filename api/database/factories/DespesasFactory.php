<?php

namespace Database\Factories;

use App\Models\Despesas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DespesasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Despesas::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_usuario' => function() {
                return User::factory()->create()->id;
            },            
            'descricao' => $this->faker->text(),
            'anexo' => $this->faker->text(),
            'data_criacao' => now(),
            'valor' => $this->faker->numberBetween(10, 200)
        ];
    }
}
