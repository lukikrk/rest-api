<?php

declare(strict_types=1);

namespace App\Shared\CQRS;

interface QueryBus
{
    /** @psalm-suppress PossiblyUnusedMethod */
    public function query(Query $query): mixed;
}
