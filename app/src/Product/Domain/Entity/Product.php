<?php

declare(strict_types=1);

namespace App\Product\Domain\Entity;

class Product
{
    public function __construct(
        private string $id,
        private string $name,
        private int $price,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
