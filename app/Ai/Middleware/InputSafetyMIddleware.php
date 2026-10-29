<?php

namespace App\Ai\Middleware;

use Closure;
use Laravel\Ai\Messages\MessageRole;
use Laravel\Ai\PendingStep;

class InputSafetyMiddleware
{
    public function handle(PendingStep $step, Closure $next)
    {
        $text = collect($step->messages)
            ->reverse()
            ->first(fn ($message): bool => $message->role === MessageRole::User)
            ?->content ?? '';

        $blocked = [
            'password',
            'credit card',
            'api key',
        ];

        foreach ($blocked as $word) {
            if (stripos($text, $word) !== false) {
                throw new \Exception('Input blocked by safety filter.');
            }
        }

        return $next($step);
    }
}
