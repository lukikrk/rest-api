<?php

declare(strict_types=1);

namespace App\Product\Domain\DTO;

final readonly class CreateProductDTO
{
    public function __construct(
        public string $name,
        public int $price,
        public ?string $id = null,
    ) {
    }
}
