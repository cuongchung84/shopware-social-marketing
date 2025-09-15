<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Service;

use Psr\Log\LoggerInterface;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Swag\SocialMarketing\Service\Clients\FacebookClient;
use Swag\SocialMarketing\Service\Clients\InstagramClient;
use Swag\SocialMarketing\Service\Clients\TikTokClient;

class SocialPostService
{
    private EntityRepository $productRepository;
    private FacebookClient $facebookClient;
    private InstagramClient $instagramClient;
    private TikTokClient $tikTokClient;
    private LoggerInterface $logger;
    private SystemConfigService $systemConfigService;

    private EntityRepository $logRepository;

    public function __construct(
        EntityRepository $productRepository,
        FacebookClient $facebookClient,
        InstagramClient $instagramClient,
        TikTokClient $tikTokClient,
        LoggerInterface $logger,
        SystemConfigService $systemConfigService,
        EntityRepository $logRepository
    ) {
        $this->productRepository = $productRepository;
        $this->facebookClient = $facebookClient;
        $this->instagramClient = $instagramClient;
        $this->tikTokClient = $tikTokClient;
        $this->logger = $logger;
        $this->systemConfigService = $systemConfigService;
        $this->logRepository = $logRepository;
    }

    public function postProduct(string $productId): void
    {
        $product = $this->fetchProduct($productId);

        if (!$product) {
            $this->logger->error("Product with ID {$productId} not found.");
            return;
        }

        $productData = $this->buildProductData($product);

        if ($this->isFacebookEnabled()) {
            $this->logger->info('Posting product to Facebook.', ['product_id' => $productId]);
            $success = $this->facebookClient->postProduct($productData);
            $this->logResult($productId, 'facebook', $success);
        }

        if ($this->isInstagramEnabled()) {
            $this->logger->info('Posting product to Instagram.', ['product_id' => $productId]);
            $success = $this->instagramClient->postProduct($productData);
            $this->logResult($productId, 'instagram', $success);
        }

        if ($this->isTikTokEnabled()) {
            $this->logger->info('Posting product to TikTok.', ['product_id' => $productId]);
            $success = $this->tikTokClient->postProduct($productData);
            $this->logResult($productId, 'tiktok', $success);
        }
    }

    private function logResult(string $productId, string $network, bool $success): void
    {
        $this->logRepository->create([
            [
                'productId' => $productId,
                'network' => $network,
                'status' => $success ? 'success' : 'failure',
            ],
        ], Context::createDefaultContext());
    }

    private function fetchProduct(string $productId): ?ProductEntity
    {
        return $this->productRepository->search(new Criteria([$productId]), Context::createDefaultContext())->first();
    }

    private function buildProductData(ProductEntity $product): array
    {
        return [
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice()->first()->getGross(),
            'image_url' => $product->getCover()->getMedia()->getUrl(),
            'product_link' => 'not_implemented', // How to get the product link?
        ];
    }

    private function isFacebookEnabled(): bool
    {
        return (bool)$this->systemConfigService->get('SwagSocialMarketing.config.facebookAppId');
    }

    private function isInstagramEnabled(): bool
    {
        return (bool)$this->systemConfigService->get('SwagSocialMarketing.config.instagramAppId');
    }

    private function isTikTokEnabled(): bool
    {
        return (bool)$this->systemConfigService->get('SwagSocialMarketing.config.tiktokAppKey');
    }
}
