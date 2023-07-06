<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts;

use Carbon\Carbon;
use Ragnarok\Fenrir\Enums\EmbedType;

class Embed
{
    public ?string $title;
    public ?EmbedType $type;
    public ?string $description;
    public ?string $url;
    public ?Carbon $timestamp;
    public ?int $color;
    public ?EmbedFooter $footer;
    public ?EmbedImage $image;
    public ?EmbedThumbnail $thumbnail;
    public ?EmbedVideo $video;
    public ?EmbedProvider $provider;
    public ?EmbedAuthor $author;
    /**
     * @var \Ragnarok\Fenrir\Parts\EmbedField[]
     */
    public ?array $fields;

    public function setType(string $value): void
    {
        $this->type = EmbedType::from($value);
    }
}
