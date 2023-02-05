<?php

declare(strict_types=1);

namespace Exan\Dhp\Parts;

/**
 * Not recommended to use in your own application
 *
 * @see https://discord.com/developers/docs/reference#uploading-files
 */
class MultipartField
{
    /**
     * @var string[] $headers
     */
    public function __construct(
        private string $name,
        private string $content,
        private ?string $fileName = null,
        private array $headers = [],
    ) {
    }

    public function __toString(): string
    {
        $out = 'Content-Disposition: form-data; name="' . $this->name . '"';

        if (!is_null($this->fileName)) {
            $out .= '; filename="' . urlencode($this->fileName) . '"';
        }

        $out .= PHP_EOL;

        foreach ($this->headers as $header => $value) {
            $out .= $header . ': ' . $value . PHP_EOL;
        }

        $out .= PHP_EOL . $this->content . PHP_EOL;

        return $out;
    }
}
