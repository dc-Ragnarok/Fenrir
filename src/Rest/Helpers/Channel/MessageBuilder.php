<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers\Channel;

use Exan\Dhp\Exceptions\Rest\Helpers\MessageBuilder\TooManyStickersException;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddAttachment;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddComponent;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddEmbed;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddFile;
use Exan\Dhp\Rest\Helpers\Channel\Message\AllowMentions;
use Exan\Dhp\Rest\Helpers\Channel\Message\MultipartMessage;
use Exan\Dhp\Rest\Helpers\Channel\Message\SetContent;
use Exan\Dhp\Rest\Helpers\Channel\Message\SetFlags;
use Exan\Dhp\Rest\Helpers\MultipartCapable;

/**
 * @see https://discord.com/developers/docs/resources/channel#create-message
 */
class MessageBuilder implements MultipartCapable
{
    use AddAttachment;
    use AddComponent;
    use AddEmbed;
    use AddFile;
    use AllowMentions;
    use SetContent;
    use SetFlags;
    use MultipartMessage;

    private $data = [];

    private $files = [];

    public function setNonce(string $nonce): MessageBuilder
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
     * @see https://discord.com/developers/docs/resources/channel#message-reference-object-message-reference-structure
     */
    public function setReference(
        string $channelId,
        string $messageId,
        bool $failIfNotExists,
        ?string $guildId = null
    ): MessageBuilder {
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
     * Up to 3 stickers
     *
     * @throws TooManyStickersException
     */
    public function addSticker(string $stickerId): MessageBuilder
    {
        if (isset($this->data['stickers'])) {
            if (count($this->data['stickers']) === 3) {
                throw new TooManyStickersException();
            }
        } else {
            $this->data['stickers'] = [];
        }

        $this->data['stickers'][] = $stickerId;

        return $this;
    }

    public function get(): array
    {
        return $this->data;
    }
}