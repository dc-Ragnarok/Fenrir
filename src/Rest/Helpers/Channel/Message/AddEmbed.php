<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Message;

use Ragnarok\Fenrir\Rest\Helpers\Channel\EmbedBuilder;

trait AddEmbed
{
    /** @var EmbedBuilder[] */
    private array $embeds;

    /**
     * Deduplicated by url
     * Up to 6000 characters across all text fields
     * Up to 25 fields total
     * @see https://discord.com/developers/docs/resources/channel#embed-object
     */
    public function addEmbed(EmbedBuilder $embed): self
    {
        if (!isset($this->embeds)) {
            $this->embeds = [];
        }

        $this->embeds[] = $embed;

        return $this;
    }

    /** @return EmbedBuilder[] */
    public function getEmbeds(): ?array
    {
        return $this->embeds ?? null;
    }

    public function hasEmbeds(): bool
    {
        return isset($this->embeds);
    }
}
