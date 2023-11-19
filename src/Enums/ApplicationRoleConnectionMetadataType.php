<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum ApplicationRoleConnectionMetadataType: int
{
    case INTEGER_LESS_THAN_OR_EQUAL = 1;
    case INTEGER_GREATER_THAN_OR_EQUAL = 2;
    case INTEGER_EQUAL = 3;
    case INTEGER_NOT_EQUAL = 4;
    case DATETIME_LESS_THAN_OR_EQUAL = 5;
    case DATETIME_GREATER_THAN_OR_EQUAL = 6;
    case BOOLEAN_EQUAL = 7;
    case BOOLEAN_NOT_EQUAL = 8;
}
