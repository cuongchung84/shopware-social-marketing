<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Core\Content\SocialMarketingLog;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;

class SocialMarketingLogDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'swag_social_marketing_log';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new StringField('product_id', 'productId'))->addFlags(new Required()),
            (new StringField('network', 'network'))->addFlags(new Required()),
            (new StringField('status', 'status'))->addFlags(new Required()),
            new StringField('message', 'message'),
        ]);
    }
}
