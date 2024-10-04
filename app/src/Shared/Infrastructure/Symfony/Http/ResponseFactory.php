<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Http;

use App\Shared\Serialization\Format;
use Symfony\Component\HttpFoundation\Response;

interface ResponseFactory
{
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
    ): Response;
}
