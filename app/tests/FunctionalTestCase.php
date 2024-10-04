<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class FunctionalTestCase extends WebTestCase
{
    protected const string URI_PREFIX = '/api';

    /**
     * @param array<string, mixed> $options
     * @param array<string, mixed> $server
     */
    protected static function client(array $options = [], array $server = []): KernelBrowser
    {
        if (static::$booted) {
            static::ensureKernelShutdown();
        }

        return static::createClient($options, $server);
    }

    /** @param array<mixed> $expectedViolations */
    protected function assertResponseIsValidationFailed(Response $response, array $expectedViolations): void
    {
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response = $this->getResponseContent($response);

        $this->assertEquals('VALIDATION_FAILED', $response['errorCode']);
        $this->assertEquals('Validation failed.', $response['message']);

        $violations = $response['violations'];

        foreach ($expectedViolations as $field => $expectedViolation) {
            $index = array_search($field, array_column($violations, 'property'));

            $violation = $violations[$index] ?? null;

            $this->assertNotNull($violation);

            $this->assertEquals($expectedViolation['code'], $violation['code']);
            $this->assertEquals($expectedViolation['message'], $violation['message']);
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function getResponseContent(Response $response): array
    {
        return json_decode($response->getContent(), true);
    }

    /**
     * @param array<mixed> $params
     */
    protected function generateUrl(string $path, array $params = []): string
    {
        $url = str_replace(array_keys($params), array_values($params), $path);

        return sprintf('%s%s', self::URI_PREFIX, $url);
    }
}
