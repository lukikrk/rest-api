<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Symfony\Controller;

use App\Product\Application\CQRS\Query\GetProduct;
use App\Product\Domain\Entity\Product;
use App\Shared\CQRS\QueryBus;
use App\Shared\Infrastructure\Symfony\Http\ResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product/{id}', methods: [Request::METHOD_GET])]
final readonly class GetProductController
{
    public function __construct(
        private QueryBus $queryBus,
        private ResponseFactory $responseFactory,
    ) {
    }

    public function __invoke(Product $product): Response
    {
        $product = $this->queryBus->query(new GetProduct($product->getId()));

        return $this->responseFactory->create($product);
    }
}
