<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Attributes\Partial;

class InteractionDataResolved
{
    /**
     * @var array<string, User>
     */
    public ?array $users;
    /**
     * @var array<string, GuildMember>
     */
    #[Partial]
    public ?array $members;
    /**
     * @var array<string, Role>
     */
    public ?array $roles;
    /**
     * @var array<string, Channel>
     */
    #[Partial]
    public ?array $channels;
    /**
     * @var array<string, Message>
     */
    #[Partial]
    public ?array $messages;
    /**
     * @var array<string, Attachment>
     */
    public ?array $attachments;
}
