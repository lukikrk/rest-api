<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\CQRS;

use App\Shared\CQRS\Query;
use App\Shared\CQRS\QueryBus as QueryBusInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class QueryBus implements QueryBusInterface
{
    public function __construct(
        private MessageBusInterface $queryBus,
    ) {
    }

    public function query(Query $query): mixed
    {
        $envelope = $this->queryBus->dispatch($query);

        /**
         * @var HandledStamp|null $handledStamp
         *
         * @psalm-suppress UnnecessaryVarAnnotation
         */
        $handledStamp = $envelope->all(HandledStamp::class)[0] ?? null;

        return $handledStamp?->getResult();
    }
}
