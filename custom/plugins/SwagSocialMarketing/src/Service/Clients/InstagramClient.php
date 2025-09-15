<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Service\Clients;

use Psr\Log\LoggerInterface;
use Swag\SocialMarketing\Service\ConfigService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InstagramClient
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
        $appId = $this->configService->getInstagramAppId();
        $appSecret = $this->configService->getInstagramAppSecret();
        $accessToken = $this->configService->getInstagramAccessToken();

        if (!$appId || !$appSecret || !$accessToken) {
            $this->logger->error('Instagram API credentials are not configured.');
            return false;
        }

        try {
            $response = $this->httpClient->request('POST', 'https://graph.facebook.com/v14.0/me/media', [
                'query' => [
                    'access_token' => $accessToken,
                ],
                'body' => [
                    'image_url' => $productData['image_url'],
                    'caption' => "{$productData['name']}\n\n{$productData['description']}\n\nPrice: {$productData['price']}\n\n{$productData['product_link']}",
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $this->logger->info('Product posted to Instagram successfully.');
                return true;
            }

            $this->logger->error('Failed to post product to Instagram.', [
                'status_code' => $response->getStatusCode(),
                'response' => $response->getContent(false),
            ]);

            return false;
        } catch (\Exception $e) {
            $this->logger->error('An error occurred while posting product to Instagram.', [
                'exception' => $e,
            ]);

            return false;
        }
    }
}
