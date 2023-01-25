<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers;

class GetReactionsBuilder
{
    private $data = [];

    public function setAfter(string $after): GetReactionsBuilder
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function setLimit(int $limit): GetReactionsBuilder
    {
        $this->data['limit'] = min(max($limit, 1), 100);

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
