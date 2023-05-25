<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum AllowedMentionType: string
{
    case ROLES = 'roles';
    case USERS = 'users';
    case EVERYONE = 'everyone';
}
