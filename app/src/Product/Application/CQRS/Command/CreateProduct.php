<?php

declare(strict_types=1);

namespace App\Product\Application\CQRS\Command;

use App\Shared\CQRS\Command;

final readonly class CreateProduct implements Command
{
    public function __construct(
        public string $id,
        public string $name,
        public int $price,
    ) {
    }
}
