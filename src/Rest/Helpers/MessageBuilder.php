<?php

namespace Exan\Dhp\Rest\Helpers;

/**
 * @see https://discord.com/developers/docs/resources/channel#create-message
 */
class MessageBuilder
{
    private $data = [];

    /**
     * @var string $content Up to 2000 characters
     */
    public function setContent(string $content): MessageBuilder
    {
        $this->data['content'] = $content;

        return $this;
    }

    public function setNonce(string|int $nonce): MessageBuilder
    {
        $this->data['nonce'] = $nonce;

        return $this;
    }

    public function setTts(bool $tts): MessageBuilder
    {
        $this->data['tts'] = $tts;

        return $this;
    }

    /**
     * Deduplicated by url
     * Up to 6000 characters across all text fields
     * Up to 25 fields total
     * @see https://discord.com/developers/docs/resources/channel#embed-object
     */
    public function addEmbed(EmbedBuilder $embed): MessageBuilder
    {
        if (!isset($this->data['embeds'])) {
            $this->data['embeds'] = [];
        }

        $this->data['embeds'][] = $embed->get();

        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object
     */
    public function allowMentions(AllowedMentionsBuilder $allowedMentions): MessageBuilder
    {
        $this->data['allowed_mentions'] = $allowedMentions->get();

        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#message-reference-object-message-reference-structure
     */
    public function setReference(string $channelId, string $messageId, bool $failIfNotExists, ?string $guildId = null): MessageBuilder
    {
        $this->data['message_reference'] = [
            'channel_id' => $channelId,
            'message_id' => $messageId,
            'fail_if_not_exists' => $failIfNotExists,
        ];

        if (!is_null($guildId)) {
            $this->data['message_reference']['guild_id'] = $guildId;
        }

        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/interactions/message-components#component-object
     */
    public function addComponent(ComponentBuilder $component): MessageBuilder
    {
        if (!isset($this->data['components'])) {
            $this->data['components'] = [];
        }

        $this->data['components'][] = $component->get();

        return $this;
    }

    /**
     * Up to 3 stickers
     */
    public function addSticker(string $stickerId): MessageBuilder
    {
        if (!isset($this->data['stickers'])) {
            $this->data['stickers'] = [];
        }

        $this->data['stickers'][] = $stickerId;

        return $this;
    }

    public function addFile(): MessageBuilder
    {
        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#attachment-object
     */
    public function addAttachment(): MessageBuilder
    {
        return $this;
    }

    public function setFlags(int $flags): MessageBuilder
    {
        $this->data['flags'] = $flags;
        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
