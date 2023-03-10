<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\IntegrationExpireBehaviors;
use Carbon\Carbon;
use Exan\Fenrir\Enums\Parts\Scopes;

class Integration
{
    public string $id;
    public string $name;
    public string $type;
    public bool $enabled;
    public ?bool $syncing;
    public ?string $role_id;
    public ?bool $enable_emoticons;
    public ?IntegrationExpireBehaviors $expire_behavior;
    public ?int $expire_grace_period;
    public ?User $user;
    public Account $account;
    public ?Carbon $synced_at;
    public ?int $subscriber_count;
    public ?bool $revoked;
    public ?Application $application;
    /**
     * @var \Exan\Fenrir\Enums\Parts\Scopes[]
     */
    public ?array $scopes;

    public function setExpireBehavior(int $value): void
    {
        $this->expire_behavior = IntegrationExpireBehaviors::from($value);
    }

    public function setScopes(array $value): void
    {
        $this->scopes = [];

        foreach ($value as $entry) {
            $this->scopes[] = Scopes::from($entry);
        }
    }
}
