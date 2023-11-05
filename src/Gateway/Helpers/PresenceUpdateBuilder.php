<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Helpers;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\StatusType;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class PresenceUpdateBuilder
{
    use GetNew;

    private ?Carbon $since = null;
    private array $activities = [];
    private StatusType $status = StatusType::ONLINE;
    private bool $afk = false;

    public function setSince(Carbon $since): self
    {
        $this->since = $since;

        return $this;
    }

    public function getSince(): ?Carbon
    {
        return $this->since;
    }

    public function addActivity(ActivityBuilder $activity): self
    {
        $this->activities[] = $activity;

        return $this;
    }

    public function setActivities(ActivityBuilder ...$activities): self
    {
        $this->activities = $activities;

        return $this;
    }

    public function getActivities(): array
    {
        return $this->activities;
    }

    public function setStatus(StatusType $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): ?StatusType
    {
        return $this->status ?? null;
    }

    public function setAfk(bool $afk): self
    {
        $this->afk = $afk;

        return $this;
    }

    public function getAfk(): bool
    {
        return $this->afk;
    }

    public function get(): array
    {
        $data = [
            'since' => $this->since ?? null,
            'activities' => array_map(
                fn (ActivityBuilder $activityBuilder) => $activityBuilder->get(),
                $this->activities
            ),
            'status' => $this->status->value,
            'afk' => $this->afk,
        ];

        return $data;
    }
}
