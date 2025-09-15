<?php declare(strict_types=1);

namespace Swag\SocialMarketing\Core\Content\SocialMarketingLog;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class SocialMarketingLogEntity extends Entity
{
    use EntityIdTrait;

    protected string $productId;
    protected string $network;
    protected string $status;
    protected ?string $message;

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function setNetwork(string $network): void
    {
        $this->network = $network;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }
}
