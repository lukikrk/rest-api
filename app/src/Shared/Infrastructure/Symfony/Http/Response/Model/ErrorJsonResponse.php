<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Http\Response\Model;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ErrorJsonResponse extends JsonResponse
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        string $errorCode = 'UNKNOWN_ERROR',
        string $message = 'Unknown error occurred.',
        int $status = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $headers = [],
    ) {
        $data = ['errorCode' => $errorCode, 'message' => $message];

        parent::__construct($data, $status, $headers);
    }
}
