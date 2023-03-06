<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Exan\Fenrir\Const\Validation\ItemLimit;
use Exan\Fenrir\Rest\Helpers\GetNew;

class GetReactionsBuilder
{
    use GetNew;

    private array $data = [];

    public function setAfter(string $after): GetReactionsBuilder
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function getAfter(): ?string
    {
        return isset($this->data['after']) ? $this->data['after'] : null;
    }

    public function setLimit(int $limit): GetReactionsBuilder
    {
        $this->data['limit'] = ItemLimit::withinLimit($limit);

        return $this;
    }

    public function getLimit(): ?int
    {
        return isset($this->data['limit']) ? $this->data['limit'] : null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
