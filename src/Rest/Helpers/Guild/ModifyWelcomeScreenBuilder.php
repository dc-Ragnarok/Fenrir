<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/guild#modify-guild-welcome-screen
 */
class ModifyWelcomeScreenBuilder
{
    use GetNew;

    private array $data = [];

    public function setDescription(?string $description): self
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->data['enabled'] = $enabled;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->data['enabled'] ?? null;
    }

    public function addChannel(
        string $channelId,
        string $description,
        ?string $emojiId = null,
        ?string $emojiName = null
    ): self {
        $this->data['welcome_channels'][] = [
            'channel_id' => $channelId,
            'description' => $description,
            'emoji_id' => $emojiId,
            'emoji_name' => $emojiName,
        ];

        return $this;
    }

    /** @return ?array[] */
    public function getChannels(): ?array
    {
        return $this->data['welcome_channels'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
