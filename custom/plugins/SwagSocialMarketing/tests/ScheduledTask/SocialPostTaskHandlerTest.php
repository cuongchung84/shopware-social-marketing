<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Test\ScheduledTask;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Swag\SocialMarketing\ScheduledTask\SocialPostTaskHandler;
use Swag\SocialMarketing\Service\SocialPostService;

class SocialPostTaskHandlerTest extends TestCase
{
    public function testRun(): void
    {
        $socialPostService = $this->createMock(SocialPostService::class);
        $socialPostService->expects(static::exactly(2))->method('postProduct');

        $productRepository = $this->createMock(EntityRepository::class);
        $productRepository->method('search')->willReturn(
            new EntitySearchResult(
                2,
                new \Shopware\Core\Framework\DataAbstractionLayer\EntityCollection([
                    $this->createMock(\Shopware\Core\Content\Product\ProductEntity::class),
                    $this->createMock(\Shopware\Core\Content\Product\ProductEntity::class),
                ]),
                null,
                new \Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria(),
                Context::createDefaultContext()
            )
        );

        $logger = $this->createMock(LoggerInterface::class);

        $handler = new SocialPostTaskHandler(
            $socialPostService,
            $productRepository,
            $logger
        );

        $handler->run();
    }
}
