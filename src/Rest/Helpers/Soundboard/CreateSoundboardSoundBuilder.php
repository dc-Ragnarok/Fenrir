<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Soundboard;

use Ragnarok\Fenrir\Enums\SoundData;
use Ragnarok\Fenrir\Rest\Helpers\GetBase64Sound;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class CreateSoundboardSoundBuilder
{
    use GetNew;
    use GetBase64Sound;

    private array $data = [];

    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function setSound(string $content, SoundData $soundData): self
    {
        $this->data['sound'] = $this->getBase64Sound($content, $soundData);

        return $this;
    }

    public function getSound(): ?string
    {
        return $this->data['sound'] ?? null;
    }

    public function setVolume(float $volume): self
    {
        $this->data['volume'] = $volume;

        return $this;
    }

    public function getVolume(): ?float
    {
        return $this->data['volume'] ?? null;
    }

    public function setEmojiId(?string $emojiId): self
    {
        $this->data['emoji_id'] = $emojiId;

        return $this;
    }

    public function getEmojiId(): ?string
    {
        return $this->data['emoji_id'] ?? null;
    }

    public function setEmojiName(?string $emojiName): self
    {
        $this->data['emoji_name'] = $emojiName;

        return $this;
    }

    public function getEmojiName(): ?string
    {
        return $this->data['emoji_name'] ?? null;
    }

    public function get(): array
    {
        return $this->data;
    }
}
