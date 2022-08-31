<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'cpf' => $this->faker->cpf(false),
            'logradouro' => $this->faker->streetName,
            'cidade' => $this->faker->city,
            'uf' => $this->faker->stateAbbr,
            'cep' => str_replace('-', '', $this->faker->postcode),
            'numero' => $this->faker->randomNumber(3),
            'complemento' => $this->faker->secondaryAddress,
            'telefone' => $this->faker->phoneNumberCleared,
        ];
    }
}
