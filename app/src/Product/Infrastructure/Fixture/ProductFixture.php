<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Fixture;

use App\Product\Domain\Entity\Product;

interface ProductFixture
{
    public function product(): Product;
}
