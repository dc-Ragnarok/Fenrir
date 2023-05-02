<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Gateway\Helpers;

use Ragnarok\Fenrir\Enums\Gateway\ActivityType;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#activity-object
 */
class ActivityBuilder
{
    use GetNew;

    private $data = [];

    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-types
     */
    public function setType(ActivityType $type): self
    {
        $this->data['type'] = $type->value;

        return $this;
    }

    /**
     * Only for streaming activity type
     * Supports youtube & twitch
     */
    public function setUrl(string $url): self
    {
        $this->data['url'] = $url;

        return $this;
    }

    public function setEmoji(EmojiBuilder $emoji): self
    {
        $this->data['emoji'] = $emoji->get();

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
