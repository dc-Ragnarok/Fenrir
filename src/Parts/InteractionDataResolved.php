<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;

class InteractionDataResolved
{
    /**
     * @var array<string, User>
     */
    public ?array $users;
    /**
     * @var array<string, GuildMember>
     */
    public ?array $members;
    /**
     * @var array<string, Role>
     */
    public ?array $roles;
    /**
     * @var array<string, Channel>
     */
    public ?array $channels;
    /**
     * @var array<string, Message>
     */
    public ?array $messages;
    /**
     * @var array<string, Attachment>
     */
    public ?array $attachments;
}
