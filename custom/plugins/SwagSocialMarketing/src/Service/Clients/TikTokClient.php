<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Service\Clients;

use Psr\Log\LoggerInterface;
use Swag\SocialMarketing\Service\ConfigService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TikTokClient
{
    private ConfigService $configService;
    private HttpClientInterface $httpClient;
    private LoggerInterface $logger;

    public function __construct(
        ConfigService $configService,
        HttpClientInterface $httpClient,
        LoggerInterface $logger
    ) {
        $this->configService = $configService;
        $this->httpClient = $httpClient;
        $this->logger = $logger;
    }

    public function postProduct(array $productData): bool
    {
        $appKey = $this->configService->getTiktokAppKey();
        $appSecret = $this->configService->getTiktokAppSecret();
        $accessToken = $this->configService->getTiktokAccessToken();

        if (!$appKey || !$appSecret || !$accessToken) {
            $this->logger->error('TikTok API credentials are not configured.');
            return false;
        }

        try {
            $response = $this->httpClient->request('POST', 'https://open-api.tiktok.com/share/video/upload/', [
                'query' => [
                    'open_id' => 'test', // This should be the user's open_id
                    'access_token' => $accessToken,
                ],
                'body' => [
                    'video_url' => $productData['image_url'], // TikTok uses video_url, but we'll use the image_url for now
                    'text' => "{$productData['name']}\n\n{$productData['description']}\n\nPrice: {$productData['price']}\n\n{$productData['product_link']}",
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $this->logger->info('Product posted to TikTok successfully.', ['product_id' => $productData['id']]);
                return true;
            }

            $this->logger->error('Failed to post product to TikTok.', [
                'product_id' => $productData['id'],
                'status_code' => $response->getStatusCode(),
                'response' => $response->getContent(false),
            ]);

            return false;
        } catch (\Exception $e) {
            $this->logger->error('An error occurred while posting product to TikTok.', [
                'product_id' => $productData['id'],
                'exception' => $e,
            ]);

            return false;
        }
    }
}
