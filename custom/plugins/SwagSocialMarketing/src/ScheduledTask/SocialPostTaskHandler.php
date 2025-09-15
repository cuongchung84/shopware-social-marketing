<?php

declare(strict_types=1);

namespace Swag\SocialMarketing\ScheduledTask;

use Psr\Log\LoggerInterface;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use Swag\SocialMarketing\Service\SocialPostService;

class SocialPostTaskHandler extends ScheduledTaskHandler
{
    private SocialPostService $socialPostService;
    private EntityRepository $productRepository;
    private LoggerInterface $logger;

    public function __construct(
        SocialPostService $socialPostService,
        EntityRepository $productRepository,
        LoggerInterface $logger
    ) {
        $this->socialPostService = $socialPostService;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
    }

    public static function getHandledMessages(): iterable
    {
        return [SocialPostTask::class];
    }

    public function run(): void
    {
        $this->logger->info('Running social post task.');

        $products = $this->productRepository->search(
            new Criteria(),
            \Shopware\Core\Framework\Context::createDefaultContext()
        );

        foreach ($products->getIds() as $productId) {
            $this->socialPostService->postProduct($productId);
        }

        $this->logger->info('Finished social post task.');
    }
}
