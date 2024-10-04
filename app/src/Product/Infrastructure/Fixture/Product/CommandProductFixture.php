<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Fixture\Product;

use App\Product\Application\CQRS\Command\CreateProduct;
use App\Product\Domain\Entity\Product;
use App\Product\Domain\Repository\ProductRepository;
use App\Product\Infrastructure\Fixture\ProductFixture;
use App\Product\Infrastructure\Fixture\Sample\ProductSample;
use App\Shared\CQRS\CommandBus;

final readonly class CommandProductFixture implements ProductFixture
{
    public function __construct(
        private CommandBus $commandBus,
        private ProductRepository $productRepository,
    ) {
    }

    public function product(): Product
    {
        $command = new CreateProduct($id = ProductSample::PRODUCT_ID, ...ProductSample::productSample());

        $this->commandBus->dispatch($command);

        return $this->productRepository->find($id);
    }
}
