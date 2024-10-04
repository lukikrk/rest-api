<?php

declare(strict_types=1);

namespace App\Tests\Functional\Product;

use App\Product\Infrastructure\Fixture\Sample\ProductSample;
use App\Tests\Functional\Product\DataProvider\InvalidProductDataProvider;
use App\Tests\FunctionalTestCase;
use JsonException;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CreateProductTest extends FunctionalTestCase
{
    #[Test]
    public function itShouldCreateProduct(): void
    {
        $client = $this->makeRequest(ProductSample::productSample());

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $content = $this->getResponseContent($client->getResponse());

        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('name', $content);
        $this->assertArrayHasKey('price', $content);

        $this->assertSame('Socks', $content['name']);
        $this->assertSame(1000, $content['price']);
    }

    /**
     * @param array<string, string|int> $invalidData
     * @param array<string, array<string, string>> $expectedViolations
     */
    #[Test]
    #[DataProviderExternal(InvalidProductDataProvider::class, 'provide')]
    public function itShouldResponseWithUnprocessableEntityWhenInvalidDataProvided(
        array $invalidData,
        array $expectedViolations,
    ): void {
        $client = $this->makeRequest($invalidData);

        $this->assertResponseIsValidationFailed($client->getResponse(), $expectedViolations);
    }

    /**
     * @param array<mixed> $body
     *
     * @throws JsonException
     */
    private function makeRequest(array $body): KernelBrowser
    {
        $client = self::client();

        $client->request(
            Request::METHOD_POST,
            $this->generateUrl('/product'),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($body),
        );

        return $client;
    }
}
