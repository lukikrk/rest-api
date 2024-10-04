<?php

declare(strict_types=1);

namespace App\Product\Application\CQRS\Command;

use App\Product\Domain\DTO\CreateProductDTO;
use App\Product\Domain\Factory\ProductFactory;
use App\Product\Domain\Repository\ProductRepository;
use App\Shared\CQRS\CommandHandler;
use App\Shared\CQRS\CommandMapper;

final readonly class CreateProductHandler implements CommandHandler
{
    public function __construct(
        private CommandMapper $mapper,
        private ProductFactory $factory,
        private ProductRepository $repository,
    ) {
    }

    public function __invoke(CreateProduct $command): void
    {
        $product = $this->factory->create(
            $this->mapper->commandToDTO($command, CreateProductDTO::class)
        );

        $this->repository->save($product);
    }
}
