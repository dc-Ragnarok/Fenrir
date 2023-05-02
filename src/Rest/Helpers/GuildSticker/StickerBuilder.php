<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\GuildSticker;

use Discord\Http\Multipart\MultipartBody;
use Discord\Http\Multipart\MultipartField;
use Mimey\MimeTypes;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class StickerBuilder
{
    use GetNew;

    private array $data = [];
    private array $file;

    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function setDescription(string $description): self
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->data['description'] ?? null;
    }

    public function setTags(string $tags): self
    {
        $this->data['tags'] = $tags;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->data['tags'] ?? null;
    }

    public function setFile(string $content, string $fileExtension): self
    {
        $this->file = [
            'content' => $content,
            'extension' => $fileExtension,
            'content-type' => (new MimeTypes())->getMimeType($fileExtension)
        ];

        return $this;
    }

    public function getFile(): ?array
    {
        return $this->file ?? null;
    }

    public function get(): MultipartBody
    {
        return new MultipartBody([
            new MultipartField(
                'files[0]',
                $this->file['content'],
                ['Content-Type' => $this->file['content-type']],
                'sticker.' . $this->file['extension']
            ),
            new MultipartField(
                'payload_json',
                json_encode($this->data),
                ['Content-Type' => 'application/json'],
                null
            )
        ]);
    }
}
