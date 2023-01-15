<?php

namespace Exan\Dhp\Rest\Helpers;

class MessageBuilder
{
    private $data = [];

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

    public function addEmbed(EmbedBuilder $embed): MessageBuilder
    {
        if (!isset($this->data['embeds'])) {
            $this->data['embeds'] = [];
        }

        $this->data['embeds'][] = $embed->get();

        return $this;
    }

    public function allowMentions(AllowedMentionsBuilder $allowedMentions): MessageBuilder
    {
        $this->data['allowed_mentions'] = $allowedMentions->get();

        return $this;
    }

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

    public function addComponent(ComponentBuilder $component): MessageBuilder
    {
        if (!isset($this->data['components'])) {
            $this->data['components'] = [];
        }

        $this->data['components'][] = $component->get();

        return $this;
    }

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

    public function setPayloadJson(): MessageBuilder
    {
        return $this;
    }

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
