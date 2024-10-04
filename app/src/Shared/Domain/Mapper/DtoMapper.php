<?php

declare(strict_types=1);

namespace App\Shared\Domain\Mapper;

use App\Shared\Serialization\Serializer;

final readonly class DtoMapper
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function dtoToArray(object $dto): array
    {
        return json_decode($this->serializer->serialize($dto), true);
    }

    /**
     * @template T
     *
     * @param array<string, mixed> $array
     * @param class-string<T> $dtoClass
     * @param array<string, mixed> $additionalData
     *
     * @return object&T
     */
    public function arrayToDTO(array $array, string $dtoClass, array $additionalData = []): object
    {
        return $this->serializer->deserialize(
            json_encode([...$array, ...$additionalData]),
            $dtoClass
        );
    }
}
