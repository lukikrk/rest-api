<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Exception;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

interface ExceptionHandler
{
    public function handle(ExceptionEvent $event): void;

    public function priority(): int;

    public function supports(Throwable $throwable): bool;
}
