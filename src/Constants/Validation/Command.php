<?php

declare(strict_types=1);

namespace Exan\Fenrir\Constants\Validation;

class Command
{
    public const NAME_REGEX = '/^[-_\p{L}\p{N}\p{sc=Deva}\p{sc=Thai}]{1,32}$/';
}
