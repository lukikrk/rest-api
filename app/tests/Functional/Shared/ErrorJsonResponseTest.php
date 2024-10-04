<?php

declare(strict_types=1);

namespace App\Tests\Functional\Shared;

use App\Tests\FunctionalTestCase;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Request;

final class ErrorJsonResponseTest extends FunctionalTestCase
{
    #[Test]
    public function itShouldResponseWithJsonErrorFormat(): void
    {
        $client = self::client();

        $client->request(Request::METHOD_GET, '/uri-does-not-exist');

        $this->assertResponseStatusCodeSame(404);

        $content = $this->getResponseContent($client->getResponse());

        $this->assertArrayHasKey('errorCode', $content);
        $this->assertArrayHasKey('message', $content);

        $this->assertEquals('Not Found', $content['errorCode']);
        $this->assertStringContainsString('No route found for', $content['message']);
    }
}
