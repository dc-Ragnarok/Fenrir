<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Exceptions\Rest\Helpers\Command;

use Exception;
use Ragnarok\Fenrir\Constants\Validation\Command;

class InvalidCommandNameException extends Exception
{
    public function __construct(public readonly string $name)
    {
        parent::__construct(sprintf(
            'Command name "%s" does not match required pattern "%s"',
            $this->name,
            Command::NAME_REGEX
        ));
    }
}
