<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

class InteractionDataResolved
{
    /**
     * @var array<string, User>
     */
    public ?array $users;
    /**
     * @partial
     * @var array<string, GuildMember>
     */
    public ?array $members;
    /**
     * @var array<string, Role>
     */
    public ?array $roles;
    /**
     * @partial
     * @var array<string, Channel>
     */
    public ?array $channels;
    /**
     * @partial
     * @var array<string, Message>
     */
    public ?array $messages;
    /**
     * @var array<string, Attachment>
     */
    public ?array $attachments;
}
