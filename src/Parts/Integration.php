<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\IntegrationExpireBehavior;
use Ragnarok\Fenrir\Enums\Scope;

class Integration
{
    public string $id;
    public string $name;
    public string $type;
    public bool $enabled;
    public ?bool $syncing;
    public ?string $role_id;
    public ?bool $enable_emoticons;
    public ?IntegrationExpireBehavior $expire_behavior;
    public ?int $expire_grace_period;
    public ?User $user;
    public Account $account;
    public ?Carbon $synced_at;
    public ?int $subscriber_count;
    public ?bool $revoked;
    public ?Application $application;
    /**
     * @var \Ragnarok\Fenrir\Enums\Scope[]
     */
    public ?array $scopes;

    public function setExpireBehavior(int $value): void
    {
        $this->expire_behavior = IntegrationExpireBehavior::from($value);
    }

    public function setScopes(array $value): void
    {
        $this->scopes = [];

        foreach ($value as $entry) {
            $this->scopes[] = Scope::from($entry);
        }
    }
}
