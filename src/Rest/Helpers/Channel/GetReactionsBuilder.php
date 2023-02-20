<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel;

use Exan\Finrir\Const\Validation\ItemLimit;

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
        $this->data['limit'] = ItemLimit::withinLimit($limit);

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
