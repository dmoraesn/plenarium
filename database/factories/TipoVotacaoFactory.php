<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TipoVotacaoFactory extends Factory
{
    public function definition(): array
    {
        $criterios = ['maioria_simples', 'maioria_absoluta', 'maioria_qualificada', 'personalizado'];
        $criterio = $this->faker->randomElement($criterios);

        return [
            'nome' => $this->faker->unique()->words(2, true), // Ex.: "Votação Especial"
            'descricao' => $this->faker->sentence(),
            'criterio' => $criterio,
            'percentual' => $criterio === 'personalizado' ? $this->faker->numberBetween(50, 80) : null,
            'min_votos' => $criterio === 'personalizado' ? $this->faker->numberBetween(5, 15) : null,
            'condicoes_adicionais' => $criterio === 'personalizado' ? $this->faker->sentence() : null,
            'ativo' => $this->faker->boolean(90),
        ];
    }
}
