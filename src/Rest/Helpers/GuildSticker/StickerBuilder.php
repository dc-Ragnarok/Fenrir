<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\GuildSticker;

use Exan\Fenrir\Parts\Multipart;
use Exan\Fenrir\Parts\MultipartField;

class StickerBuilder
{
    private array $data = [];
    private array $file;

    public function setName(string $name): StickerBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return isset($this->data['name']) ? $this->data['name'] : null;
    }

    public function setDescription(string $description): StickerBuilder
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return isset($this->data['description']) ? $this->data['description'] : null;
    }

    public function setTags(string $tags): StickerBuilder
    {
        $this->data['tags'] = $tags;

        return $this;
    }

    public function getTags(): ?string
    {
        return isset($this->data['tags']) ? $this->data['tags'] : null;
    }

    public function setFile(string $content, string $fileExtension): StickerBuilder
    {
        $this->file = [
            'content' => $content,
            'extension' => $fileExtension,
            'content-type' => (new \Mimey\MimeTypes())->getMimeType($fileExtension)
        ];

        return $this;
    }

    public function getFile(): ?string
    {
        return isset($this->file) ? $this->file : null;
    }

    public function get(): Multipart
    {
        return new Multipart([
            new MultipartField(
                'files[0]',
                $this->file['content'],
                'sticker.' . $this->file['extension'],
                ['Content-Type' => $this->file['content-type']]
            ),
            new MultipartField(
                'payload_json',
                json_encode($this->data),
                null,
                ['Content-Type' => 'application/json']
            )
        ]);
    }
}
