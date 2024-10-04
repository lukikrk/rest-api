<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Exception\Subscriber;

use App\Shared\Infrastructure\Symfony\Exception\ExceptionHandlerAggregator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ExceptionHandlerAggregator $aggregator,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $this->aggregator->handle($event);
    }
}
