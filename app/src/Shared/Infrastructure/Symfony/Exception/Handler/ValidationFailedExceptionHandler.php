<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Exception\Handler;

use App\Shared\Infrastructure\Symfony\Exception\ExceptionHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Throwable;

final readonly class ValidationFailedExceptionHandler implements ExceptionHandler
{
    public function handle(ExceptionEvent $event): void
    {
        /** @var ValidationFailedException $validationException */
        $validationException = $event->getThrowable()->getPrevious();

        /** @var array<ConstraintViolation> $violations */
        $violations = iterator_to_array($validationException->getViolations());

        $event->setResponse(new JsonResponse(
            [
                'message' => 'Validation failed.',
                'errorCode' => 'VALIDATION_FAILED',
                'violations' => array_map(
                    fn (ConstraintViolation $violation) => [
                        'message' => $violation->getMessage(),
                        'code' => $violation->getCode(),
                        'property' => $violation->getPropertyPath(),
                        'params' => $violation->getParameters(),
                    ],
                    $violations
                ),
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        ));
    }

    public function priority(): int
    {
        return 2;
    }

    public function supports(Throwable $throwable): bool
    {
        return true === $throwable->getPrevious() instanceof ValidationFailedException;
    }
}
