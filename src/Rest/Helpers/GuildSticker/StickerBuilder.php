<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\GuildSticker;

use Discord\Http\Multipart\MultipartBody;
use Discord\Http\Multipart\MultipartField;
use Exan\Fenrir\Rest\Helpers\GetNew;

class StickerBuilder
{
    use GetNew;

    private array $data = [];
    private array $file;

    public function setName(string $name): StickerBuilder
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setDescription(string $description): StickerBuilder
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function setTags(string $tags): StickerBuilder
    {
        $this->data['tags'] = $tags;

        return $this;
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
