<?php

declare(strict_types=1);

namespace Exan\Fenrir\Exceptions\Rest\Helpers\Command;

use Exan\Fenrir\Constants\Validation\Command;
use Exception;

class InvalidCommandNameException extends Exception
{
    public function __construct(public readonly string $name)
    {
        parent::__construct(sprintf(
            'Command name "%s" does not match required pattern "%s"',
            $this->name,
            (string) Command::NAME_REGEX
        ));
    }
}
