<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Websocket\Helpers;

use Ragnarok\Fenrir\Enums\Gateway\ActivityType;
use Ragnarok\Fenrir\Rest\Helpers\Emoji\EmojiBuilder;

/**
 * @see https://discord.com/developers/docs/topics/gateway-events#activity-object
 */
class ActivityBuilder
{
    private $data = [];

    public function setName(string $name): ActivityBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/topics/gateway-events#activity-object-activity-types
     */
    public function setType(ActivityType $type): ActivityBuilder
    {
        $this->data['type'] = $type->value;

        return $this;
    }

    /**
     * Only for streaming activity type
     * Supports youtube & twitch
     */
    public function setUrl(string $url): ActivityBuilder
    {
        $this->data['url'] = $url;

        return $this;
    }

    public function setEmoji(EmojiBuilder $emoji): ActivityBuilder
    {
        $this->data['emoji'] = $emoji->get();

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}
