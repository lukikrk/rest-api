<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Fixture\Sample;

final readonly class ProductSample
{
    public const string PRODUCT_ID = '128bb1c9-d0c2-48fe-855c-cb3c20843912';

    /** @return array<string, string|int> */
    public static function productSample(): array
    {
        return [
            'name' => 'Socks',
            'price' => 1000,
        ];
    }
}
