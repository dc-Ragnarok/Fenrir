<?php

namespace Tests\Exan\Dhp\Rest\Helpers\Channel\Channel\Shared;

class DummyTraitTester
{
    protected array $data;

    public function get(): array
    {
        return $this->data;
    }
}
