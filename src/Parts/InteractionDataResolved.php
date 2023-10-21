<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;

class InteractionDataResolved
{
    /**
     * Array of string => User
     * @var \Ragnarok\Fenrir\Parts\User[]
     */
    public ?array $users;
    /**
     * Array of string => GuildMember
     * @var \Ragnarok\Fenrir\Parts\GuildMember[]
     */
    public ?array $members;
    /**
     * Array of string => Role
     * @var \Ragnarok\Fenrir\Parts\Role[]
     */
    public ?array $roles;
    /**
     * Array of string => Channel
     * @var \Ragnarok\Fenrir\Parts\Channel[]
     */
    public ?array $channels;
    /**
     * Array of string => Message
     * @var \Ragnarok\Fenrir\Parts\Message[]
     */
    public ?array $messages;
    /**
     * Array of string => Attachment
     * @var \Ragnarok\Fenrir\Parts\Attachment[]
     */
    public ?array $attachments;
}
