<?php

declare(strict_types=1);

namespace App\Product\Domain\View;

use App\Product\Domain\Entity\Product;

final readonly class ProductView
{
    public function __construct(
        public string $id,
        public string $name,
        public int $price,
    ) {
    }

    public static function fromEntity(Product $product): self
    {
        return new self($product->getId(), $product->getName(), $product->getPrice());
    }
}
