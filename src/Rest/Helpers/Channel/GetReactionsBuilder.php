<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Constants\Validation\ItemLimit;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class GetReactionsBuilder
{
    use GetNew;

    private array $data = [];

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
