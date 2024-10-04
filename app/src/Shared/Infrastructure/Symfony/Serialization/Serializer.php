<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Serialization;

use App\Shared\Serialization\Format;
use App\Shared\Serialization\Serializer as SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

final readonly class Serializer implements SerializerInterface
{
    public function __construct(
        private SymfonySerializerInterface $serializer,
    ) {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function serialize(mixed $data, Format $format = Format::json, array $context = []): string
    {
        return $this->serializer->serialize($data, $format->value, $context);
    }

    public function deserialize(mixed $data, string $type, Format $format = Format::json, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format->value, $context);
    }
}
