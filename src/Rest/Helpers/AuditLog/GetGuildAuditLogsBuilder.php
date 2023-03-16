<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\AuditLog;

use Exan\Fenrir\Constants\Validation\ItemLimit;
use Exan\Fenrir\Rest\Helpers\GetNew;

class GetGuildAuditLogsBuilder
{
    use GetNew;

    private array $data = [];

    public function setUserId(string $userId): GetGuildAuditLogsBuilder
    {
        $this->data['user_id'] = $userId;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->data['user_id'] ?? null;
    }

    public function setActionType(int $actionType): GetGuildAuditLogsBuilder
    {
        $this->data['action_type'] = $actionType;

        return $this;
    }

    public function getActionType(): ?int
    {
        return $this->data['action_type'] ?? null;
    }

    public function setBefore(string $before): GetGuildAuditLogsBuilder
    {
        $this->data['before'] = $before;

        return $this;
    }

    public function getBefore(): ?string
    {
        return $this->data['before'] ?? null;
    }

    public function setAfter(string $after): GetGuildAuditLogsBuilder
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function getAfter(): ?string
    {
        return $this->data['after'] ?? null;
    }

    public function setLimit(int $limit): GetGuildAuditLogsBuilder
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
