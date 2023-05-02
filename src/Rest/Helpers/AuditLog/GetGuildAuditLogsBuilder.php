<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\AuditLog;

use Ragnarok\Fenrir\Constants\Validation\ItemLimit;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class GetGuildAuditLogsBuilder
{
    use GetNew;

    private array $data = [];

    public function setUserId(string $userId): self
    {
        $this->data['user_id'] = $userId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->data['user_id'] ?? null;
    }

    public function setActionType(int $actionType): self
    {
        $this->data['action_type'] = $actionType;

        return $this;
    }

    public function getActionType(): ?int
    {
        return $this->data['action_type'] ?? null;
    }

    public function setBefore(string $before): self
    {
        $this->data['before'] = $before;

        return $this;
    }

    public function getBefore(): ?string
    {
        return $this->data['before'] ?? null;
    }

    public function setAfter(string $after): self
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function getAfter(): ?string
    {
        return $this->data['after'] ?? null;
    }

    public function setLimit(int $limit): self
    {
        $this->data['limit'] = ItemLimit::withinLimit($limit);

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->data['limit'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
