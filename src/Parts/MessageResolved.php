<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Ragnarok\Fenrir\Mapping\ArrayMapping;

/**
 * @see https://discord.com/developers/docs/interactions/receiving-and-responding#interaction-object-resolved-data-structure
 */
class MessageResolved
{
    /**
     * @var User[]
     */
    #[ArrayMapping(User::class)]
    public array $users;

    /**
     * @var GuildMember[]
     */
    #[ArrayMapping(GuildMember::class)]
    public array $members;

    /**
     * @var Role[]
     */
    #[ArrayMapping(Role::class)]
    public array $roles;

    /**
     * @var Channel[]
     */
    #[ArrayMapping(Channel::class)]
    public array $channels;

    /**
     * @var Message[]
     */
    #[ArrayMapping(Message::class)]
    public array $messages;

    /**
     * @var Attachment[]
     */
    #[ArrayMapping(Attachment::class)]
    public array $attachments;
}
