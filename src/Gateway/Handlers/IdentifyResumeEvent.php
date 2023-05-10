<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Handlers;

class IdentifyResumeEvent extends IdentifyEvent
{
    public function execute(): void
    {
        $this->connection->resume();
        parent::execute();
    }
}
