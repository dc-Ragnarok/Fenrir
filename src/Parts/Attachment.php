<?php

namespace Exan\Dhp\Parts;


class Attachment
{
    public string $id;
    public string $filename;
    public ?string $description;
    public ?string $content_type;
    public int $size;
    public string $url;
    public string $proxy_url;
    public ?int $height;
    public ?int $width;
    public ?bool $ephemeral;
}
