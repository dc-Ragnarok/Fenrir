<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

class EmbedImage
{
    public string $url;
    public ?string $proxy_url;
    public ?int $height;
    public ?int $width;
}
