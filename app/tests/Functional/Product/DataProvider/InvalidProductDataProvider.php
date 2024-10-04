<?php

declare(strict_types=1);

namespace App\Tests\Functional\Product\DataProvider;

use App\Product\Infrastructure\Fixture\Sample\ProductSample;
use App\Tests\DataProvider;

final readonly class InvalidProductDataProvider extends DataProvider
{
    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     *
     * @return array<mixed>
     */
    public static function provide(): array
    {
        $body = ProductSample::productSample();

        return [
            [
                self::unset($body, ['name']),
                ['name' => ['code' => null, 'message' => 'This value should be of type string.']],
            ],
            [
                self::unset($body, ['price']),
                ['price' => ['code' => null, 'message' => 'This value should be of type int.']],
            ],
        ];
    }
}
