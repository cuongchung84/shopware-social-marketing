<?php

declare(strict_types=1);

namespace Swag\SocialMarketing\ScheduledTask;

use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTask;

class SocialPostTask extends ScheduledTask
{
    public static function getTaskName(): string
    {
        return 'swag.social_post_task';
    }

    public static function getDefaultInterval(): int
    {
        return 21600; // 6 hours
    }
}
