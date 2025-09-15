<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Test\Logging;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Test\TestCaseBase\IntegrationTestBehaviour;
use Swag\SocialMarketing\Service\SocialPostService;

class LoggingServiceTest extends TestCase
{
    use IntegrationTestBehaviour;

    public function testLogging(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(static::exactly(3))->method('info');

        $logRepository = $this->getContainer()->get('swag_social_marketing_log.repository');

        $socialPostService = $this->getContainer()->get(SocialPostService::class);
        $socialPostService->setLogger($logger);
        $socialPostService->setLogRepository($logRepository);

        $productRepository = $this->getContainer()->get('product.repository');
        $productId = $this->createProduct($productRepository);

        $socialPostService->postProduct($productId);

        $criteria = new \Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria();
        $criteria->addFilter(new \Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter('productId', $productId));
        $logs = $logRepository->search($criteria, Context::createDefaultContext());

        static::assertSame(3, $logs->getTotal());
    }

    private function createProduct(EntityRepository $productRepository): string
    {
        $productId = \Shopware\Core\Framework\Uuid\Uuid::randomHex();
        $productRepository->create([
            [
                'id' => $productId,
                'name' => 'Test Product',
                'productNumber' => 'SW10000',
                'stock' => 10,
                'price' => [
                    [
                        'currencyId' => \Shopware\Core\Defaults::CURRENCY,
                        'gross' => 10,
                        'net' => 9,
                        'linked' => false,
                    ],
                ],
                'tax' => ['name' => '19%', 'taxRate' => 19],
                'manufacturer' => ['name' => 'shopware AG'],
                'visibilities' => [
                    [
                        'salesChannelId' => $this->getSalesChannelApiSource()->getSalesChannelId(),
                        'visibility' => \Shopware\Core\Content\Product\Aggregate\ProductVisibility\ProductVisibilityDefinition::VISIBILITY_ALL,
                    ],
                ],
            ],
        ], Context::createDefaultContext());

        return $productId;
    }
}
