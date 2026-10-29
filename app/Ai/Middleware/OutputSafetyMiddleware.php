<?php

namespace App\Ai\Middleware;

use Closure;
use Laravel\Ai\Gateway\StepResponse;
use Laravel\Ai\PendingStep;

class OutputSafetyMiddleware
{
    public function handle(PendingStep $step, Closure $next)
    {
        return $next($step)->then(function (StepResponse $response): void {
            $blocked = [
                'ssn',
                'phish',
            ];

            foreach ($blocked as $word) {
                if (stripos($response->text, $word) !== false) {
                    $response->text = 'Output blocked by safety filter.';

                    return;
                }
            }
        });
    }
}
