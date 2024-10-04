<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Product\Domain\Entity\Product;

interface ProductRepository
{
    public function find(string $id): ?Product;

    public function save(Product $product): void;
}
