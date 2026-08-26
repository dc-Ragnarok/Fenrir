<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/guild#guild-onboarding-object-prompt-option-structure
 */
class OnboardingPromptOptionBuilder
{
    use GetNew;

    private array $data = [];

    /**
     * Discord requires an id on every option, including new ones, and accepts
     * any placeholder for options that do not exist yet.
     */
    public function setId(string $id): self
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->data['id'] ?? null;
    }

    public function setTitle(string $title): self
    {
        $this->data['title'] = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    public function setDescription(?string $description): self
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function setEmoji(?string $emojiId = null, ?string $emojiName = null, ?bool $animated = null): self
    {
        $this->data['emoji_id'] = $emojiId;
        $this->data['emoji_name'] = $emojiName;

        if (!is_null($animated)) {
            $this->data['emoji_animated'] = $animated;
        }

        return $this;
    }

    /**
     * @param string[] $roleIds Roles granted when this option is picked
     */
    public function setRoleIds(array $roleIds): self
    {
        $this->data['role_ids'] = array_values($roleIds);

        return $this;
    }

    /** @return ?string[] */
    public function getRoleIds(): ?array
    {
        return $this->data['role_ids'] ?? null;
    }

    /**
     * @param string[] $channelIds Channels shown when this option is picked
     */
    public function setChannelIds(array $channelIds): self
    {
        $this->data['channel_ids'] = array_values($channelIds);

        return $this;
    }

    /** @return ?string[] */
    public function getChannelIds(): ?array
    {
        return $this->data['channel_ids'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
