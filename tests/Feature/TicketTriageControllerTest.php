<?php

use App\Ai\Agents\TicketTriager;
use App\Models\AiUsage;
use App\Models\Ticket;
use App\Models\User;
use Laravel\Ai\Responses\Data\Meta;
use Laravel\Ai\Responses\Data\TextUsage;
use Laravel\Ai\Responses\StructuredTextResponse;

it('records the provider token usage for a triage run', function () {
    $user = User::factory()->create();
    $ticket = Ticket::factory()->create();

    TicketTriager::fake([
        new StructuredTextResponse(
            [
                'priority' => 1,
                'department' => 'billing',
                'sentiment' => 'angry',
                'tags' => ['billing'],
                'summary' => 'Charged twice for the same subscription.',
            ],
            'Triage complete.',
            new TextUsage(inputTokens: 120, outputTokens: 45),
            new Meta('openai', 'gpt-4o-mini'),
        ),
    ]);

    $this->actingAs($user)
        ->post(route('tickets.ai.triage', $ticket))
        ->assertOk();

    $usage = AiUsage::sole();

    expect($usage->prompt_tokens)->toBe(120)
        ->and($usage->completion_tokens)->toBe(45)
        ->and($usage->total_tokens)->toBe(165);
});
