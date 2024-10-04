<?php

declare(strict_types=1);

namespace App\Shared\CQRS;

interface EventBus
{
    /** @psalm-suppress PossiblyUnusedMethod */
    public function dispatch(Event $event): void;
}
