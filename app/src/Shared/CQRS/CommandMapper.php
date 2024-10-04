<?php

declare(strict_types=1);

namespace App\Shared\CQRS;

use App\Shared\Serialization\Serializer;

final readonly class CommandMapper
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    /**
     * @template T
     *
     * @param class-string<T> $commandClass
     * @param array<string, mixed> $additionalData
     *
     * @return Command&T
     */
    public function dtoToCommand(object $dto, string $commandClass, array $additionalData = []): Command
    {
        $json = $this->serializer->serialize($dto);

        $merged = [...json_decode($json, true), ...$additionalData];

        return $this->serializer->deserialize(json_encode($merged), $commandClass);
    }

    /**
     * @template T
     *
     * @param class-string<T> $dtoClass
     *
     * @return object&T
     */
    public function commandToDTO(Command $command, string $dtoClass): object
    {
        $json = $this->serializer->serialize($command);

        return $this->serializer->deserialize($json, $dtoClass);
    }
}
