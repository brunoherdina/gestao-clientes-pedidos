<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\Pedidos;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $min = 100;
        $max = 900;
        return [
            'id_cliente' => Clientes::inRandomOrder()->first()->id,
            'valor_frete' => rand ($min * 0, $max * 10) / 10,
            'data_entrega_prevista' => Carbon::now()->addDays(random_int(2, 10))->format('Y-m-d'),
        ];
    }
}
