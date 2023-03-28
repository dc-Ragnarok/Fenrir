<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Message;

use Discord\Http\Multipart\MultipartBody;
use Discord\Http\Multipart\MultipartField;

trait MultipartMessage
{
    public function getMultipart(array $data): MultipartBody
    {
        $fields = array_map(function ($fileData, int $index) {
            $headers = isset($fileData['type'])
                ? ['Content-Type' => $fileData['type']]
                : [];

            return new MultipartField(
                'files[' . $index . ']',
                $fileData['content'],
                $headers,
                $fileData['name']
            );
        }, $this->getFiles(), array_keys($this->getFiles()));

        $fields[] = new MultipartField(
            'payload_json',
            json_encode($data),
            ['Content-Type' => 'application/json'],
            null
        );

        return new MultipartBody($fields);
    }

    public function requiresMultipart(): bool
    {
        return $this->hasFiles();
    }
}
