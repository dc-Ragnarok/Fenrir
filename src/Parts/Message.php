<?php

namespace Exan\Dhp\Parts;

use Carbon\Carbon;
use Exan\Dhp\Enums\Parts\MessageTypes;
use Exan\Dhp\Enums\Parts\MessageComponentTypes;

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
     * @var \Exan\Dhp\Enums\Parts\User[]
     */
    public array $mentions;
    /**
     * @var string[]
     */
    public array $mention_roles;
    /**
     * @var \Exan\Dhp\Enums\Parts\ChannelMention[]
     */
    public ?array $mention_channels;
    /**
     * @var \Exan\Dhp\Enums\Parts\Attachment[]
     */
    public array $attachments;
    /**
     * @var \Exan\Dhp\Enums\Parts\Embed[]
     */
    public array $embeds;
    /**
     * @var \Exan\Dhp\Enums\Parts\Reaction[]
     */
    public ?array $reactions;
    public ?string $nonce;
    public bool $pinned;
    public ?string $webhook_id;
    public MessageTypes $type;
    public ?MessageActivity $activity;
    public ?Application $application;
    public ?string $application_id;
    public ?MessageReference $message_reference;
    public ?string $flags;
    public ?Message $referenced_message;
    public ?MessageInteraction $interaction;
    public ?Channel $thread;
    /**
     * @var \Exan\Dhp\Enums\Parts\MessageComponentTypes[]
     */
    public array $components;
    /**
     * @var \Exan\Dhp\Enums\Parts\MessageStickerItem[]
     */
    public ?array $sticker_items;
    /**
     * @var \Exan\Dhp\Enums\Parts\Sticker[]
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
