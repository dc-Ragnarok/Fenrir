<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers\Channel;

use Exan\Dhp\Exceptions\Rest\Helpers\MessageBuilder\TooManyStickersException;
use Exan\Dhp\Parts\Multipart;
use Exan\Dhp\Parts\MultipartField;

/**
 * @see https://discord.com/developers/docs/resources/channel#create-message
 */
class MessageBuilder
{
    private $data = [];

    private $files = [];

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

    /**
     * @var string $contentType
     *  Content-Type header to be used for this file.
     *  If not provided, this is guessed based on file extension.
     * @see https://discord.com/developers/docs/reference#uploading-files
     */
    public function addFile(string $fileName, string $content, ?string $contentType = null): MessageBuilder
    {
        $file = [
            'name' => $fileName,
            'content' => $content,
        ];

        $this->files[] = &$file;

        if (!is_null($contentType)) {
            $file['type'] = $contentType;

            return $this;
        }

        $fileInfo = pathinfo($fileName);
        if (empty($fileInfo['extension'])) {
            return $this;
        }

        $type = (new \Mimey\MimeTypes())->getMimeType($fileInfo['extension']);

        if (!is_null($type)) {
            $file['type'] = $type;
        }

        return $this;
    }

    /**
     * @see https://discord.com/developers/docs/resources/channel#attachment-object
     */
    public function addAttachment(AttachmentBuilder $attachment): MessageBuilder
    {
        if (!isset($this->data['attachments'])) {
            $this->data['attachments'] = [];
        }

        $this->data['attachments'][] = $attachment->get();

        return $this;
    }

    public function setFlags(int $flags): MessageBuilder
    {
        $this->data['flags'] = $flags;
        return $this;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function requiresMultipart()
    {
        return $this->files !== [];
    }

    public function get(): array
    {
        return $this->data;
    }

    public function getMultipart(): Multipart
    {
        $fields = array_map(function ($fileData, int $index) {
            $headers = isset($fileData['type'])
                ? ['Content-Type' => $fileData['type']]
                : [];

            return new MultipartField(
                'files[' . $index . ']',
                $fileData['content'],
                $fileData['name'],
                $headers
            );
        }, $this->files, array_keys($this->files));

        $fields[] = new MultipartField(
            'payload_json',
            json_encode($this->get()),
            null,
            ['Content-Type' => 'application/json']
        );

        return new Multipart($fields);
    }
}
