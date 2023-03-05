<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\AuditLog;

use Ragnarok\Fenrir\Const\Validation\ItemLimit;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class GetGuildAuditLogsBuilder
{
    use GetNew;

    private $data = [];

    public function setUserId(string $userId): GetGuildAuditLogsBuilder
    {
        $this->data['user_id'] = $userId;

        return $this;
    }

    public function setActionType(int $actionType): GetGuildAuditLogsBuilder
    {
        $this->data['action_type'] = $actionType;

        return $this;
    }

    public function setBefore(string $before): GetGuildAuditLogsBuilder
    {
        $this->data['before'] = $before;

        return $this;
    }

    public function setAfter(string $after): GetGuildAuditLogsBuilder
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function setLimit(int $limit): GetGuildAuditLogsBuilder
    {
        $this->data['limit'] = ItemLimit::withinLimit($limit);

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
