<?php

namespace Database\Factories;

use App\Models\TicketTag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketTag>
 */
class TicketTagFactory extends Factory
{
    protected $model = TicketTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }
}
