<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Ragnarok\Fenrir\Const\Validation\ItemLimit;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class GetMessagesBuilder
{
    use GetNew;

    private $data = [];

    public function setAround(string $around): GetMessagesBuilder
    {
        $this->data['around'] = $around;

        return $this;
    }

    public function setBefore(string $before): GetMessagesBuilder
    {
        $this->data['before'] = $before;

        return $this;
    }

    public function setAfter(string $after): GetMessagesBuilder
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function setLimit(int $limit): GetMessagesBuilder
    {
        $limit = ItemLimit::withinLimit($limit);

        $this->data['limit'] = $limit;

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
