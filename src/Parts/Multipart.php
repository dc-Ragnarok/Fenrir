<?php

namespace Exan\Dhp\Parts;

use Ramsey\Uuid\Uuid;

class Multipart
{
    public const BOUNDARY_PREFIX = 'DHP-BOUNDARY';

    private function getBoundary(): string
    {
        return self::BOUNDARY_PREFIX . '-' . strtoupper(Uuid::uuid1());
    }

    /**
     * @var MultipartField[] $fields
     */
    public function __construct(public array $fields, private ?string $boundary = null)
    {
        $this->boundary = $this->boundary ?? $this->getBoundary();
    }

    public function getBody()
    {
        $boundaryStart = '----' . $this->boundary;
        $boundaryEnd = $boundaryStart . '--';

        $convertedFields = array_map(
            function (MultipartField $field) {
                return (string) $field;
            },
            $this->fields
        );

        $fieldsString = implode(PHP_EOL . $boundaryStart . PHP_EOL, $convertedFields);

        return implode(PHP_EOL, [
            $boundaryStart,
            $fieldsString,
            $boundaryEnd
        ]);
    }

    public function getHeaders(?string $body = null): array
    {
        $body = $body ?? $this->getBody();

        return [
            'Content-Type' => 'multipart/form-data; boundary=--' . $this->boundary . '',
            'Content-Length' => strlen($this->getBody()),
        ];
    }
}
