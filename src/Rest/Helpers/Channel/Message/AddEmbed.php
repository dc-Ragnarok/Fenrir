<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel\Message;

use Exan\Finrir\Rest\Helpers\Channel\EmbedBuilder;

trait AddEmbed
{
    /**
     * Deduplicated by url
     * Up to 6000 characters across all text fields
     * Up to 25 fields total
     * @see https://discord.com/developers/docs/resources/channel#embed-object
     */
    public function addEmbed(EmbedBuilder $embed): self
    {
        if (!isset($this->data['embeds'])) {
            $this->data['embeds'] = [];
        }

        $this->data['embeds'][] = $embed->get();

        return $this;
    }
}
