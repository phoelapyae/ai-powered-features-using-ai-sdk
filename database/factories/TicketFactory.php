<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'user_id' => User::factory(),
            'subject' => $this->faker->sentence(6),
            'status' => 'open',
            'priority' => $this->faker->numberBetween(1, 5),
            'department' => $this->faker->randomElement(['billing', 'technical', 'sales', 'account', 'other']),
            'sentiment' => $this->faker->randomElement(['angry', 'neutral', 'happy', 'urgent']),
            'ai_tags' => [],
        ];
    }
}
