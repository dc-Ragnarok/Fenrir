<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Const\Validation\ItemLimit;
use Exan\Fenrir\Rest\Helpers\GetNew;

class GetMessagesBuilder
{
    use GetNew;

    private array $data = [];

    public function setAround(string $around): GetMessagesBuilder
    {
        $this->data['around'] = $around;

        return $this;
    }

    public function getAround(): ?string
    {
        return $this->data['around'] ?? null;
    }

    public function setBefore(string $before): GetMessagesBuilder
    {
        $this->data['before'] = $before;

        return $this;
    }

    public function getBefore(): ?string
    {
        return $this->data['before'] ?? null;
    }

    public function setAfter(string $after): GetMessagesBuilder
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function getAfter(): ?string
    {
        return $this->data['after'] ?? null;
    }

    public function setLimit(int $limit): GetMessagesBuilder
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
