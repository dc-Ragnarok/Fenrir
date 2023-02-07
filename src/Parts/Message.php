<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

use Carbon\Carbon;

/**
 * @see https://discord.com/developers/docs/resources/channel#message-object
 * @todo
 */
class Message
{
    public string $id;
    public string $channel_id;
    public User $author;
    public string $content;
    public Carbon $timestamp;
    public ?Carbon $edited_timestamp;
    public bool $tts;
    public bool $mention_everyone;

    /**
     * @var \Exan\Dhp\Parts\User[]
     */
    public array $mentions;

    /**
     * @var \Exan\Dhp\Parts\Role[]
     */
    public array $mention_roles;

    /**
     * @see https://discord.com/developers/docs/resources/channel#channel-mention-object
     * @todo proper type
     */
    public ?array $mention_channels;

    /**
     * @see https://discord.com/developers/docs/resources/channel#attachment-object
     * @todo proper type
     */
    public array $attachments;

    /**
     * @see https://discord.com/developers/docs/resources/channel#embed-object
     * @todo proper type
     */
    public array $embeds;

    /**
     * @see https://discord.com/developers/docs/resources/channel#reaction-object
     * @todo proper type
     */
    public ?array $reactions;
    public ?string $nonce;
    public bool $pinned;
    public ?string $webhook_id;

    /**
     * @see https://discord.com/developers/docs/resources/channel#message-object-message-types
     * @todo create enum
     */
    public int $type;
    public ?object $activity;
    public ?Application $application;
    public ?string $application_id;
    /**
     * @see https://discord.com/developers/docs/resources/channel#message-reference-object-message-reference-structure
     * @todo proper type
     */
    public ?object $message_reference;
    public ?int $flags;
    public ?Message $referenced_message;
    /**
     * @see https://discord.com/developers/docs/interactions/receiving-and-responding#message-interaction-object-message-interaction-structure
     * @todo proper type
     */
    public ?object $interaction;
    public ?Channel $thread;

    /**
     * @see https://discord.com/developers/docs/interactions/message-components#component-object
     * @todo proper type
     */
    public ?array $components;

    /**
     * @see https://discord.com/developers/docs/resources/sticker#sticker-item-object
     * @todo proper type
     */
    public ?array $sticker_items;

    /**
     * @var \Exan\Dhp\Parts\Sticker[]
     * @deprecated
     */
    public ?array $stickers;
    public ?int $position;

    /**
     * @see https://discord.com/developers/docs/resources/channel#role-subscription-data-object
     * @todo proper type
     */
    public ?object $role_subscription_data;
}
