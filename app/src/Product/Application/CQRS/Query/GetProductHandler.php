<?php

declare(strict_types=1);

namespace App\Product\Application\CQRS\Query;

use App\Product\Domain\Repository\ProductRepository;
use App\Product\Domain\View\ProductView;
use App\Shared\CQRS\QueryHandler;

final readonly class GetProductHandler implements QueryHandler
{
    public function __construct(
        private ProductRepository $repository
    ) {
    }

    public function __invoke(GetProduct $query): ProductView
    {
        return ProductView::fromEntity($this->repository->find($query->id));
    }
}
