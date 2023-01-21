<?php

namespace Exan\Dhp\Parts;

class MultipartField
{

    /**
     * @var String[] $headers
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
