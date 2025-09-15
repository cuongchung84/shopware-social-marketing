<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Test\Service\Clients;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Swag\SocialMarketing\Service\Clients\TikTokClient;
use Swag\SocialMarketing\Service\ConfigService;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TikTokClientTest extends TestCase
{
    public function testPostProductSuccess(): void
    {
        $configService = $this->createMock(ConfigService::class);
        $configService->method('getTiktokAppKey')->willReturn('test_app_key');
        $configService->method('getTiktokAppSecret')->willReturn('test_app_secret');
        $configService->method('getTiktokAccessToken')->willReturn('test_access_token');

        $httpClient = new MockHttpClient([
            new MockResponse('{"data":{"share_id":"12345"}}', ['http_code' => 200]),
        ]);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(static::once())->method('info');

        $client = new TikTokClient($configService, $httpClient, $logger);

        $result = $client->postProduct([
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => '9.99',
            'product_link' => 'https://example.com/product',
            'image_url' => 'https://example.com/image.jpg',
        ]);

        static::assertTrue($result);
    }

    public function testPostProductFailure(): void
    {
        $configService = $this->createMock(ConfigService::class);
        $configService->method('getTiktokAppKey')->willReturn('test_app_key');
        $configService->method('getTiktokAppSecret')->willReturn('test_app_secret');
        $configService->method('getTiktokAccessToken')->willReturn('test_access_token');

        $httpClient = new MockHttpClient([
            new MockResponse('{"data":{"error_code":10001}}', ['http_code' => 200]),
        ]);

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(static::once())->method('error');

        $client = new TikTokClient($configService, $httpClient, $logger);

        $result = $client->postProduct([
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => '9.99',
            'product_link' => 'https://example.com/product',
            'image_url' => 'https://example.com/image.jpg',
        ]);

        static::assertFalse($result);
    }

    public function testPostProductMissingCredentials(): void
    {
        $configService = $this->createMock(ConfigService::class);
        $configService->method('getTiktokAppKey')->willReturn(null);

        $httpClient = $this->createMock(HttpClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(static::once())->method('error');

        $client = new TikTokClient($configService, $httpClient, $logger);

        $result = $client->postProduct([]);

        static::assertFalse($result);
    }
}
