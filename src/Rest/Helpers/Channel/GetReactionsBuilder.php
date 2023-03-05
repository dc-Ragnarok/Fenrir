<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Const\Validation\ItemLimit;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class GetReactionsBuilder
{
    use GetNew;

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
