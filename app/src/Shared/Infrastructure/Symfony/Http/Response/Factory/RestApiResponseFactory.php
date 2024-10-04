<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Http\Response\Factory;

use App\Shared\Http\Enum\ContentType;
use App\Shared\Infrastructure\Symfony\Http\ResponseFactory;
use App\Shared\Serialization\Format;
use App\Shared\Serialization\Serializer;
use Symfony\Component\HttpFoundation\Response;

final readonly class RestApiResponseFactory implements ResponseFactory
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    /**
     * @param array<string, string> $headers
     * @param array<string, mixed> $context
     */
    public function create(
        mixed $data = null,
        int $status = Response::HTTP_OK,
        Format $format = Format::json,
        array $headers = [],
        array $context = [],
    ): Response {
        $data = $this->serializer->serialize($data, $format, $context);

        $headers = [...$headers, ContentType::NAME => ContentType::fromFormat($format)->value];

        return new Response($data, $status, $headers);
    }
}
