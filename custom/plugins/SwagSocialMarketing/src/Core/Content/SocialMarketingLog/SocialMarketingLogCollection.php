<?php

declare(strict_types=1);

namespace Swag\SocialMarketing\Core\Content\SocialMarketingLog;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void              add(SocialMarketingLogEntity $entity)
 * @method void              set(string $key, SocialMarketingLogEntity $entity)
 * @method SocialMarketingLogEntity[]    getIterator()
 * @method SocialMarketingLogEntity[]    getElements()
 * @method SocialMarketingLogEntity|null get(string $key)
 * @method SocialMarketingLogEntity|null first()
 * @method SocialMarketingLogEntity|null last()
 */
class SocialMarketingLogCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return SocialMarketingLogEntity::class;
    }
}
