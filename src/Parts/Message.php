<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Carbon\Carbon;
use Exan\Fenrir\Enums\Parts\MessageTypes;
use Exan\Fenrir\Bitwise\Bitwise;
use Exan\Fenrir\Enums\Parts\MessageComponentTypes;
use Exan\Fenrir\Attributes\Partial;

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
     * @var \Exan\Fenrir\Parts\User[]
     */
    public array $mentions;
    /**
     * @var string[]
     */
    public array $mention_roles;
    /**
     * @var \Exan\Fenrir\Parts\ChannelMention[]
     */
    public ?array $mention_channels;
    /**
     * @var \Exan\Fenrir\Parts\Attachment[]
     */
    public array $attachments;
    /**
     * @var \Exan\Fenrir\Parts\Embed[]
     */
    public array $embeds;
    /**
     * @var \Exan\Fenrir\Parts\Reaction[]
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
    public ?Message $referenced_message;
    public ?MessageInteraction $interaction;
    public ?Channel $thread;
    /**
     * @var \Exan\Fenrir\Enums\Parts\MessageComponentTypes[]
     */
    public array $components;
    /**
     * @var \Exan\Fenrir\Parts\MessageStickerItem[]
     */
    public ?array $sticker_items;
    /**
     * @var \Exan\Fenrir\Parts\Sticker[]
     */
    public ?array $stickers;
    public ?int $position;
    public ?RoleSubscriptionData $role_subscription_data;

    public function setType(int $value): void
    {
        $this->type = MessageTypes::from($value);
    }

    public function setComponents(array $value): void
    {
        $this->components = [];

        foreach ($value as $entry) {
            $this->components[] = MessageComponentTypes::from($entry);
        }
    }
}
