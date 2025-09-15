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

    public function __construct(
        EntityRepository $productRepository,
        FacebookClient $facebookClient,
        InstagramClient $instagramClient,
        TikTokClient $tikTokClient,
        LoggerInterface $logger,
        SystemConfigService $systemConfigService
    ) {
        $this->productRepository = $productRepository;
        $this->facebookClient = $facebookClient;
        $this->instagramClient = $instagramClient;
        $this->tikTokClient = $tikTokClient;
        $this->logger = $logger;
        $this->systemConfigService = $systemConfigService;
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
            $this->facebookClient->postProduct($productData);
        }

        if ($this->isInstagramEnabled()) {
            $this->logger->info('Posting product to Instagram.', ['product_id' => $productId]);
            $this->instagramClient->postProduct($productData);
        }

        if ($this->isTikTokEnabled()) {
            $this->logger->info('Posting product to TikTok.', ['product_id' => $productId]);
            $this->tikTokClient->postProduct($productData);
        }
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
