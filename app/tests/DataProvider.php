<?php

declare(strict_types=1);

namespace App\Tests;

abstract readonly class DataProvider
{
    /**
     * @param array<mixed> $hash
     * @param array<mixed> $keys
     *
     * @return array<mixed>
     */
    protected static function unset(array $hash, array $keys): array
    {
        foreach ($keys as $key) {
            unset($hash[$key]);
        }

        return $hash;
    }
}
