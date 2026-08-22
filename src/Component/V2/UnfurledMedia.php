<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\V2;

/**
 * A reference to media, either an external url or an attachment on the same
 * message given as attachment://<filename>.
 *
 * @see https://discord.com/developers/docs/components/reference#unfurled-media-item-structure
 */
class UnfurledMedia
{
    public function __construct(public readonly string $url)
    {
    }

    public static function attachment(string $filename): self
    {
        return new self('attachment://' . $filename);
    }

    public function get(): array
    {
        return ['url' => $this->url];
    }
}
