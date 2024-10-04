<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Doctrine\Repository;

use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepository;
use App\Shared\Infrastructure\Doctrine\Repository;

final readonly class ORMProductRepository extends Repository implements ProductRepository
{
    public function find(string $id): ?Product
    {
        return $this->repository->find($id);
    }

    public function save(Product $product): void
    {
        $this->entityManager->persist($product);
    }

    protected function getEntityClass(): string
    {
        return Product::class;
    }
}
