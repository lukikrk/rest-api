<?php

declare(strict_types=1);

namespace App\Product\Application\CQRS\Query;

use App\Shared\CQRS\Query;

final readonly class GetProduct implements Query
{
    public function __construct(
        public string $id,
    ) {
    }
}
