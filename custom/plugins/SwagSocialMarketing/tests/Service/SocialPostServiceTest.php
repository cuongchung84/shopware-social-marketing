<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Test\Service;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Swag\SocialMarketing\Service\Clients\FacebookClient;
use Swag\SocialMarketing\Service\Clients\InstagramClient;
use Swag\SocialMarketing\Service\Clients\TikTokClient;
use Swag\SocialMarketing\Service\SocialPostService;

class SocialPostServiceTest extends TestCase
{
    public function testPostProductToAllNetworks(): void
    {
        $productRepository = $this->createMock(EntityRepository::class);
        $product = $this->createMock(ProductEntity::class);
        $product->method('getName')->willReturn('Test Product');
        $product->method('getDescription')->willReturn('Test Description');
        $product->method('getPrice')->willReturn(new \Shopware\Core\Framework\DataAbstractionLayer\Pricing\PriceCollection([new \Shopware\Core\Framework\DataAbstractionLayer\Pricing\Price('c_id', 10, 10, false)]));
        $product->method('getCover')->willReturn($this->createMock(\Shopware\Core\Content\Product\Aggregate\ProductMedia\ProductMediaEntity::class));
        $product->getCover()->method('getMedia')->willReturn($this->createMock(\Shopware\Core\Content\Media\MediaEntity::class));
        $product->getCover()->getMedia()->method('getUrl')->willReturn('https://example.com/image.jpg');

        $productRepository->method('search')->willReturn(new EntitySearchResult(1, new \Shopware\Core\Framework\DataAbstractionLayer\EntityCollection([$product]), null, new \Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria(), Context::createDefaultContext()));

        $facebookClient = $this->createMock(FacebookClient::class);
        $facebookClient->expects(static::once())->method('postProduct');

        $instagramClient = $this->createMock(InstagramClient::class);
        $instagramClient->expects(static::once())->method('postProduct');

        $tikTokClient = $this->createMock(TikTokClient::class);
        $tikTokClient->expects(static::once())->method('postProduct');

        $logger = $this->createMock(LoggerInterface::class);

        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('get')->willReturnMap([
            ['SwagSocialMarketing.config.facebookAppId', null, 'test_app_id'],
            ['SwagSocialMarketing.config.instagramAppId', null, 'test_app_id'],
            ['SwagSocialMarketing.config.tiktokAppKey', null, 'test_app_key'],
        ]);

        $service = new SocialPostService(
            $productRepository,
            $facebookClient,
            $instagramClient,
            $tikTokClient,
            $logger,
            $systemConfigService
        );

        $service->postProduct('product_id');
    }
}
