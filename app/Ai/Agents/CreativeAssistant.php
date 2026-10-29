<?php

namespace App\Ai\Agents;

use App\Ai\Middleware\InputSafetyMiddleware;
use App\Ai\Middleware\OutputSafetyMiddleware;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\UseCheapestModel;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasMiddleware;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\ProviderTool;
use Laravel\Ai\Providers\Tools\WebSearch;
use Stringable;

#[Provider(Lab::OpenAI)]
#[UseCheapestModel]
class CreativeAssistant implements Agent, HasMiddleware, HasTools
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
You are a helpful creative writing assistant.
Keep content safe, professional, and non-sensative.
PROMPT;
    }

    public function middleware(): array
    {
        return [
            InputSafetyMiddleware::class,
            OutputSafetyMiddleware::class,
        ];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return list<Agent|Tool|ProviderTool>
     */
    public function tools(): iterable
    {
        return [
            (new WebSearch)->allow([
                'laracasts.com',
                'laravel.com',
                'php.net',
            ]),
        ];
    }
}
