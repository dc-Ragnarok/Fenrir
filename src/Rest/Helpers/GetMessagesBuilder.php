<?php

namespace Exan\Dhp\Rest\Helpers;

class GetMessagesBuilder
{
    private $data = [];

    public function setAround(string $around) : GetMessagesBuilder
    {
        $this->data['around'] = $around;

        return $this;
    }

    public function setBefore(string $before) : GetMessagesBuilder
    {
        $this->data['before'] = $before;

        return $this;
    }

    public function setAfter(string $after) : GetMessagesBuilder
    {
        $this->data['after'] = $after;

        return $this;
    }

    public function setLimit(int $limit) : GetMessagesBuilder
    {
        $limit = min(max($limit, 1), 100);

        $this->data['limit'] = $limit;

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
