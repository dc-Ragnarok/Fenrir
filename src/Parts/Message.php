<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\Parts\MessageTypes;
use Ragnarok\Fenrir\Bitwise\Bitwise;
use Ragnarok\Fenrir\Attributes\Partial;

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
    public array $mentions;
    /**
     * @var string[]
     */
    public array $mention_roles;
    /**
     * @var ChannelMention[]
     */
    public ?array $mention_channels;
    /**
     * @var Attachment[]
     */
    public array $attachments;
    /**
     * @var Embed[]
     */
    public array $embeds;
    /**
     * @var Reaction[]
     */
    public ?array $reactions;
    public ?string $nonce;
    public bool $pinned;
    public ?string $webhook_id;
    public MessageTypes $type;
    public ?MessageActivity $activity;
    #[Partial]
    public ?Application $application;
    public ?string $application_id;
    public ?MessageReference $message_reference;
    public ?Bitwise $flags;
    public ?self $referenced_message;
    public ?MessageInteraction $interaction;
    public ?Channel $thread;
    /**
     * @var Component[]
     */
    public array $components;
    /**
     * @var MessageStickerItem[]
     */
    public ?array $sticker_items;
    /**
     * @var Sticker[]
     */
    public ?array $stickers;
    public ?int $position;
    public ?RoleSubscriptionData $role_subscription_data;

    public function setType(int $value): void
    {
        $this->type = MessageTypes::from($value);
    }
}
