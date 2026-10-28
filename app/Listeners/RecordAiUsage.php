<?php

namespace App\Listeners;

use App\Models\AiUsage;
use Laravel\Ai\Events\AgentPrompted;

class RecordAiUsage
{
    public function handle(AgentPrompted $event) {
        $usage = $event->response?->usage;

        if (!$usage) {
            return;
        }

        if (AiUsage::where('invocation_id', $event->invocationId)->exists()) {
            return;
        }

        $promptTokens = $usage->inputTokens ?? 0;
        $completionTokens = $usage->outputTokens ?? 0;

        AiUsage::create([
            'prompt_tokens' => $promptTokens,
            'completion_tokens' => $completionTokens,
            'total_tokens' => $promptTokens + $completionTokens,
            'cost_usd' => $usage->costUsd ?? null,
            'invocation_id' => $event->invocationId,
        ]);
    }
}
