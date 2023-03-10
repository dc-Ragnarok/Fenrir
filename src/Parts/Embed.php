<?php

declare(strict_types=1);

namespace Exan\Fenrir\Parts;

use Exan\Fenrir\Enums\Parts\EmbedTypes;
use Carbon\Carbon;

class Embed
{
    public ?string $title;
    public ?EmbedTypes $type;
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
     * @var \Exan\Fenrir\Parts\EmbedField[]
     */
    public ?array $fields;

    public function setType(string $value): void
    {
        $this->type = EmbedTypes::from($value);
    }
}
