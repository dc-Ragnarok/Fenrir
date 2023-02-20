<?php

declare(strict_types=1);

namespace Exan\Finrir\Parts;

use Carbon\Carbon;
use Exan\Finrir\Enums\Parts\MessageTypes;
use Exan\Finrir\Bitwise\Bitwise;
use Exan\Finrir\Enums\Parts\MessageComponentTypes;
use Exan\Finrir\Attributes\Partial;

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
     * @var \Exan\Finrir\Parts\User[]
     */
    public array $mentions;
    /**
     * @var string[]
     */
    public array $mention_roles;
    /**
     * @var \Exan\Finrir\Parts\ChannelMention[]
     */
    public ?array $mention_channels;
    /**
     * @var \Exan\Finrir\Parts\Attachment[]
     */
    public array $attachments;
    /**
     * @var \Exan\Finrir\Parts\Embed[]
     */
    public array $embeds;
    /**
     * @var \Exan\Finrir\Parts\Reaction[]
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
     * @var \Exan\Finrir\Enums\Parts\MessageComponentTypes[]
     */
    public array $components;
    /**
     * @var \Exan\Finrir\Parts\MessageStickerItem[]
     */
    public ?array $sticker_items;
    /**
     * @var \Exan\Finrir\Parts\Sticker[]
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
