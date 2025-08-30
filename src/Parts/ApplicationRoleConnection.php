<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

class ApplicationRoleConnection
{
    public ?string $platform_name;
    public ?string $platform_username;
    public ApplicationRoleConnectionMetadata $metadata;
}
