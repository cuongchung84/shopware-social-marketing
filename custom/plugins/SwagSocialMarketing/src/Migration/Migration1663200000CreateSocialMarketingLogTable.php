<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1663200000CreateSocialMarketingLogTable extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1663200000;
    }

    public function update(Connection $connection): void
    {
        $connection->executeStatement('
            CREATE TABLE IF NOT EXISTS `swag_social_marketing_log` (
                `id` BINARY(16) NOT NULL,
                `product_id` BINARY(16) NOT NULL,
                `network` VARCHAR(255) NOT NULL,
                `status` VARCHAR(255) NOT NULL,
                `message` TEXT NULL,
                `created_at` DATETIME(3) NOT NULL,
                `updated_at` DATETIME(3) NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
