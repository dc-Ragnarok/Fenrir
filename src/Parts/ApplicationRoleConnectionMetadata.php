<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Enums\ApplicationRoleConnectionMetadataType;

class ApplicationRoleConnectionMetadata
{
    public ApplicationRoleConnectionMetadataType $type;
    public string $key;
    public string $name;
    /**
     * @var array<string, string>
     */
    public array $name_localizations;
    public string $description;
    /**
     * @var array<string string>
     */
    public array $description_localizations;
}
