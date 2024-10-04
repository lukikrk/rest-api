<?php

declare(strict_types=1);

namespace App\Shared\Serialization;

interface Serializer
{
    /** @param array<string, mixed> $context */
    public function serialize(mixed $data, Format $format = Format::json, array $context = []): string;

    /** @param array<string, mixed> $context */
    public function deserialize(mixed $data, string $type, Format $format = Format::json, array $context = []): mixed;
}
