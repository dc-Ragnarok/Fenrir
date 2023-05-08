<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Events\Meta;

use Exan\Eventer\EventInterface;
use Psr\Log\LoggerInterface;
use Ragnarok\Fenrir\Gateway\ConnectionInterface;

abstract class MetaEvent implements EventInterface
{
    public function __construct(
        protected ConnectionInterface $connection,
        protected LoggerInterface $logger,
    ) {
    }

    public function filter(): bool
    {
        return true;
    }
}
