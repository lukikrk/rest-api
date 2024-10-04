<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract readonly class Repository
{
    protected EntityRepository $repository;

    /** @return class-string */
    abstract protected function getEntityClass(): string;

    public function __construct(
        protected EntityManagerInterface $entityManager,
    ) {
        $this->repository = $this->entityManager->getRepository($this->getEntityClass());
    }
}
