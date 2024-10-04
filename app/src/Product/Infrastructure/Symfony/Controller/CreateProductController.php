<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Symfony\Controller;

use App\Product\Application\CQRS\Command\CreateProduct;
use App\Product\Application\CQRS\Query\GetProduct;
use App\Product\Domain\DTO\CreateProductDTO;
use App\Shared\CQRS\CommandBus;
use App\Shared\CQRS\CommandMapper;
use App\Shared\CQRS\QueryBus;
use App\Shared\Infrastructure\Symfony\Http\ResponseFactory;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product', methods: [Request::METHOD_POST])]

final readonly class CreateProductController
{
    public function __construct(
        private CommandBus $commandBus,
        private CommandMapper $commandMapper,
        private QueryBus $queryBus,
        private ResponseFactory $responseFactory,
    ) {
    }

    public function __invoke(#[MapRequestPayload] CreateProductDTO $dto): Response
    {
        $id = ['id' => Uuid::uuid4()->toString()];

        $command = $this->commandMapper->dtoToCommand($dto, CreateProduct::class, $id);

        $this->commandBus->dispatch($command);

        $product = $this->queryBus->query(new GetProduct($command->id));

        return $this->responseFactory->create($product, Response::HTTP_CREATED);
    }
}
