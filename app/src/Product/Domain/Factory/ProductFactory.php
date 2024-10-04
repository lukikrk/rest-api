<?php

declare(strict_types=1);

namespace App\Product\Domain\Factory;

use App\Product\Domain\DTO\CreateProductDTO;
use App\Product\Domain\Entity\Product;

final readonly class ProductFactory
{
    public function create(CreateProductDTO $dto): Product
    {
        return new Product($dto->id, $dto->name, $dto->price);
    }
}
