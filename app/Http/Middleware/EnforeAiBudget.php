<?php

namespace App\Http\Middleware;

use App\Models\AiUsage;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforeAiBudget
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $teamId = $request->user()?->current_team_id;

        if (!$teamId) {
            return $next($request);
        }

        $tokensToday = AiUsage::query()
            ->where('team_id', $teamId)
            ->whereDate('created_at', now()->toDateString())
            ->sum('total_tokens');

        if ($tokensToday >= config('ai.daily_team_token_budget')) {
            return response()->json([
                'message' => 'Daily AI token budget reached.'
            ], 429);
        }

        return $next($request);
    }
}
