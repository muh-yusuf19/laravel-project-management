<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->catchPhrase(),
            'description' => fake()->paragraph($nbSentences = 5, $variableNbSentences = true),
            'start_date' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'end_date' => fake()->date($format = 'Y-m-d', $max = 'now')
        ];
    }
}
