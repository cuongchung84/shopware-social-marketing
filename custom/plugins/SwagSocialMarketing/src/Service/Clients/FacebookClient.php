<?php

declare(strict_types=1);

namespace Swag\SocialMarketing\Service\Clients;

use Psr\Log\LoggerInterface;
use Swag\SocialMarketing\Service\ConfigService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FacebookClient
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
        $appId = $this->configService->getFacebookAppId();
        $appSecret = $this->configService->getFacebookAppSecret();
        $accessToken = $this->configService->getFacebookAccessToken();

        if (!$appId || !$appSecret || !$accessToken) {
            $this->logger->error('Facebook API credentials are not configured.');
            return false;
        }

        try {
            $response = $this->httpClient->request('POST', 'https://graph.facebook.com/v14.0/me/feed', [
                'query' => [
                    'access_token' => $accessToken,
                ],
                'body' => [
                    'message' => "{$productData['name']}\n\n{$productData['description']}\n\n"
                . "Price: {$productData['price']}\n\n{$productData['product_link']}",
                    'link' => $productData['product_link'],
                    'picture' => $productData['image_url'],
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $this->logger->info('Product posted to Facebook successfully.', ['product_id' => $productData['id']]);
                return true;
            }

            $this->logger->error('Failed to post product to Facebook.', [
                'product_id' => $productData['id'],
                'status_code' => $response->getStatusCode(),
                'response' => $response->getContent(false),
            ]);

            return false;
        } catch (\Exception $e) {
            $this->logger->error('An error occurred while posting product to Facebook.', [
                'product_id' => $productData['id'],
                'exception' => $e,
            ]);

            return false;
        }
    }
}
