<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\CQRS;

use App\Shared\CQRS\Command;
use App\Shared\CQRS\CommandBus as CommandBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class CommandBus implements CommandBusInterface
{
    public function __construct(
        private MessageBusInterface $bus,
    ) {
    }

    public function dispatch(Command $command): void
    {
        $this->bus->dispatch($command);
    }
}
