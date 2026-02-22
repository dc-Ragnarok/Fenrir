<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Enums\MessageType;
use Ragnarok\Fenrir\Mapping\ArrayMapping;

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
     * @var User[]
     */
    #[ArrayMapping(User::class)]
    public array $mentions;
    /**
     * @var string[]
     */
    public array $mention_roles;
    /**
     * @var ChannelMention[]
     */
    #[ArrayMapping(ChannelMention::class)]
    public ?array $mention_channels;
    /**
     * @var Attachment[]
     */
    #[ArrayMapping(Attachment::class)]
    public array $attachments;
    /**
     * @var Embed[]
     */
    #[ArrayMapping(Embed::class)]
    public array $embeds;
    /**
     * @var Reaction[]
     */
    #[ArrayMapping(Reaction::class)]
    public ?array $reactions;
    public ?string $nonce;
    public bool $pinned;
    public ?string $webhook_id;
    public ?MessageType $type;
    public ?MessageActivity $activity;
    public ?Application $application;
    public ?string $application_id;
    public ?Bitwise $flags;
    public ?MessageReference $message_reference;
    /**
     * @var MessageSnapshot[]
     */
    #[ArrayMapping(MessageSnapshot::class)]
    public array $message_snapshots;
    public ?Message $referenced_message;
    public ?MessageInteractionMetadata $interaction_metadata;
    /**
     * @deprecated use $this->interaction_metadata instead
     */
    public ?MessageInteraction $interaction;
    public ?Channel $thread;
    /**
     * @var Component[]
     */
    #[ArrayMapping(Component::class)]
    public array $components;
    /**
     * @var MessageStickerItem[]
     */
    #[ArrayMapping(MessageStickerItem::class)]
    public ?array $sticker_items;
    /**
     * @var Sticker[]
     */
    #[ArrayMapping(Sticker::class)]
    public ?array $stickers;
    public ?int $position;
    public ?RoleSubscriptionData $role_subscription_data;
    public ?MessageResolved $resolved;
    public ?Poll $poll;
    public MessageCall $call;
}
