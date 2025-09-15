<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Test\Service;

use PHPUnit\Framework\TestCase;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Swag\SocialMarketing\Service\ConfigService;
use Swag\SocialMarketing\SwagSocialMarketing;

class ConfigServiceTest extends TestCase
{
    public function testGetFacebookAppId(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.facebookAppId')
            ->willReturn('test_app_id');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_app_id', $configService->getFacebookAppId());
    }

    public function testGetFacebookAppSecret(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.facebookAppSecret')
            ->willReturn('test_app_secret');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_app_secret', $configService->getFacebookAppSecret());
    }

    public function testGetFacebookAccessToken(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.facebookAccessToken')
            ->willReturn('test_access_token');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_access_token', $configService->getFacebookAccessToken());
    }

    public function testGetInstagramAppId(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.instagramAppId')
            ->willReturn('test_app_id');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_app_id', $configService->getInstagramAppId());
    }

    public function testGetInstagramAppSecret(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.instagramAppSecret')
            ->willReturn('test_app_secret');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_app_secret', $configService->getInstagramAppSecret());
    }

    public function testGetInstagramAccessToken(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.instagramAccessToken')
            ->willReturn('test_access_token');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_access_token', $configService->getInstagramAccessToken());
    }

    public function testGetTiktokAppKey(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.tiktokAppKey')
            ->willReturn('test_app_key');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_app_key', $configService->getTiktokAppKey());
    }

    public function testGetTiktokAppSecret(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.tiktokAppSecret')
            ->willReturn('test_app_secret');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_app_secret', $configService->getTiktokAppSecret());
    }

    public function testGetTiktokAccessToken(): void
    {
        $systemConfigService = $this->createMock(SystemConfigService::class);
        $systemConfigService->method('getString')
            ->with(SwagSocialMarketing::CONFIG_DOMAIN . '.tiktokAccessToken')
            ->willReturn('test_access_token');

        $configService = new ConfigService($systemConfigService);
        static::assertSame('test_access_token', $configService->getTiktokAccessToken());
    }
}
