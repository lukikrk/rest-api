<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Exception\Handler;

use App\Shared\Infrastructure\Symfony\Exception\ExceptionHandler;
use App\Shared\Infrastructure\Symfony\Http\Response\Model\ErrorJsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

final readonly class HttpExceptionHandler implements ExceptionHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    /** @SuppressWarnings(PHPMD.UndefinedVariable) */
    public function handle(ExceptionEvent $event): void
    {
        /** @var HttpException $exception */
        $exception = $event->getThrowable();

        $event->setResponse(new ErrorJsonResponse(
            Response::$statusTexts[$statusCode = $exception->getStatusCode()],
            $exception->getMessage(),
            $statusCode,
        ));

        $this->logger->error($exception);
    }

    public function priority(): int
    {
        return 1;
    }

    public function supports(Throwable $throwable): bool
    {
        return true === $throwable instanceof HttpException;
    }
}
