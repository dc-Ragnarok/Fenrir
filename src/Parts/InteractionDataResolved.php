<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Attributes\Partial;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

class InteractionDataResolved
{
    /**
     * Array of string => User
     * @var User[]
     */
    #[ArrayMapping(User::class)]
    public ?array $users;
    /**
     * Array of string => GuildMember
     * @var GuildMember[]
     */
    #[ArrayMapping(GuildMember::class)]
    public ?array $members;
    /**
     * Array of string => Role
     * @var Role[]
     */
    #[ArrayMapping(Role::class)]
    public ?array $roles;
    /**
     * Array of string => Channel
     * @var Channel[]
     */
    #[ArrayMapping(Channel::class)]
    public ?array $channels;
    /**
     * Array of string => Message
     * @var Message[]
     */
    #[ArrayMapping(Message::class)]
    public ?array $messages;
    /**
     * Array of string => Attachment
     * @var Attachment[]
     */
    #[ArrayMapping(Attachment::class)]
    public ?array $attachments;
}
