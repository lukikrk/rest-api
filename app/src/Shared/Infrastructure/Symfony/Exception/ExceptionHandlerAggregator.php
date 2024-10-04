<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Exception;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final readonly class ExceptionHandlerAggregator
{
    /** @var array<ExceptionHandler> */
    private array $exceptionHandlers;

    /**
     * @param iterable<ExceptionHandler> $exceptionHandlers
     */
    public function __construct(iterable $exceptionHandlers)
    {
        /** @var array<ExceptionHandler> $handlers */
        $handlers = array_values([...$exceptionHandlers]);

        $this->exceptionHandlers = $this->sortHandlers($handlers);
    }

    public function handle(ExceptionEvent $event): void
    {
        foreach ($this->exceptionHandlers as $exceptionHandler) {
            if (true === $exceptionHandler->supports($event->getThrowable())) {
                $exceptionHandler->handle($event);

                return;
            }
        }
    }

    /**
     * @param array<ExceptionHandler> $handlers
     *
     * @return array<ExceptionHandler>
     */
    private function sortHandlers(array $handlers): array
    {
        usort(
            $handlers,
            static fn (
                ExceptionHandler $handler1,
                ExceptionHandler $handler2,
            ): int => $handler2->priority() <=> $handler1->priority(),
        );

        return $handlers;
    }
}
