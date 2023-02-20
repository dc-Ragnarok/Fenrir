<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Message;

use Exan\Finrir\Parts\Multipart;
use Exan\Finrir\Parts\MultipartField;

trait MultipartMessage
{
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

    public function requiresMultipart(): bool
    {
        return $this->files !== [];
    }
}
