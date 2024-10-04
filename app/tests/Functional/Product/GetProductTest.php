<?php

declare(strict_types=1);

namespace App\Tests\Functional\Product;

use App\Product\Infrastructure\Fixture\ProductFixture;
use App\Tests\FunctionalTestCase;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetProductTest extends FunctionalTestCase
{
    private ProductFixture $productFixture;

    protected function setUp(): void
    {
        $container = self::getContainer();

        $this->productFixture = $container->get(ProductFixture::class);

        parent::setUp();
    }

    protected function tearDown(): void
    {
        unset($this->productFixture);

        parent::tearDown();
    }

    #[Test]
    public function itShouldGetProduct(): void
    {
        $product = $this->productFixture->product();

        $client = $this->makeRequest($product->getId());

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $content = $this->getResponseContent($client->getResponse());

        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('name', $content);
        $this->assertArrayHasKey('price', $content);

        $this->assertSame($product->getId(), $content['id']);
        $this->assertSame($product->getName(), $content['name']);
        $this->assertSame($product->getPrice(), $content['price']);
    }

    private function makeRequest(string $id): KernelBrowser
    {
        $client = self::client();

        $client->request(
            Request::METHOD_GET,
            $this->generateUrl(sprintf('/product/%s', $id)),
        );

        return $client;
    }
}
