<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Exan\Dhp\Enums\Parts\OverwriteType;

/**
 * @see https://discord.com/developers/docs/resources/channel#overwrite-object
 * @todo
 */
class Overwrite
{
    public ?string $id = null;

    public function __construct(
        public OverwriteType $type,
        public ?string $allow = null,
        public ?string $deny = null
    ) { }

    public function toArray()
    {
        return array_filter([
            'id' => $this->id,
            'type' => $this->type->value,
            'allow' => $this->allow,
            'deny' => $this->deny
        ]);
    }
}
