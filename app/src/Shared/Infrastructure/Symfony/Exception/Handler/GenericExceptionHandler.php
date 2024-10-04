<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Exception\Handler;

use App\Shared\Infrastructure\Symfony\Exception\ExceptionHandler;
use App\Shared\Infrastructure\Symfony\Http\Response\Model\ErrorJsonResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

final readonly class GenericExceptionHandler implements ExceptionHandler
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function handle(ExceptionEvent $event): void
    {
        $event->setResponse(new ErrorJsonResponse());

        $this->logger->error($event->getThrowable());
    }

    public function priority(): int
    {
        return 0;
    }

    public function supports(Throwable $throwable): bool
    {
        return true;
    }
}
