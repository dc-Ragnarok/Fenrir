<?php

declare(strict_types=1);

namespace Tests\Ragnarok\Fenrir\Rest\Helpers\Channel\Channel\Shared;

class DummyTraitTester
{
    protected array $data;

    public function get(): array
    {
        return $this->data;
    }
}
