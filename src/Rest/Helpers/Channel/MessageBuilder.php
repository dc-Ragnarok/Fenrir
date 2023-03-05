<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Discord\Http\Multipart\MultipartBody;
use Exan\Fenrir\Exceptions\Rest\Helpers\MessageBuilder\TooManyStickersException;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddAttachment;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddComponent;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddEmbed;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddFile;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AllowMentions;
use Exan\Fenrir\Rest\Helpers\Channel\Message\MultipartMessage;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetContent;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetFlags;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetTts;
use Exan\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/channel#create-message
 */
class MessageBuilder
{
    use GetNew;

    use AddAttachment;
    use AddComponent;
    use AddEmbed;
    use AddFile;
    use AllowMentions;
    use SetContent;
    use SetFlags;
    use MultipartMessage;
    use SetTts;

    private array $data = [];

    private $files = [];

    public function setNonce(string $nonce): MessageBuilder
    {
        $this->data['nonce'] = $nonce;

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

    public function get(): MultipartBody|array
    {
        if ($this->requiresMultipart()) {
            return $this->getMultipart($this->data);
        }

        return $this->data;
    }
}
