<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;

class ConfigService
{
    private const DOMAIN = 'SwagSocialMarketing.config.';

    private SystemConfigService $systemConfigService;

    public function __construct(SystemConfigService $systemConfigService)
    {
        $this->systemConfigService = $systemConfigService;
    }

    public function getFacebookAppId(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'facebookAppId');
    }

    public function getFacebookAppSecret(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'facebookAppSecret');
    }

    public function getFacebookAccessToken(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'facebookAccessToken');
    }

    public function getInstagramAppId(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'instagramAppId');
    }

    public function getInstagramAppSecret(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'instagramAppSecret');
    }

    public function getInstagramAccessToken(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'instagramAccessToken');
    }

    public function getTiktokAppKey(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'tiktokAppKey');
    }

    public function getTiktokAppSecret(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'tiktokAppSecret');
    }

    public function getTiktokAccessToken(): ?string
    {
        return $this->systemConfigService->getString(self::DOMAIN . 'tiktokAccessToken');
    }
}
