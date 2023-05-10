<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

class IdentifyHelloEvent extends IdentifyEvent
{
    public function execute(): void
    {
        $this->connection->identify();
        parent::execute();
    }
}
