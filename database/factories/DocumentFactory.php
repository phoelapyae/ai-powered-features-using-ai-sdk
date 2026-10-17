<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    protected $model = Document::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'team_id' => Team::factory(),
            'title' => $this->faker->sentence(6),
            'body' => $this->faker->paragraphs(4, true),
            'embedding' => null,
            'source_url' => null,
        ];
    }
}
