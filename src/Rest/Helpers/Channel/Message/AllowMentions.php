<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Message;

use Ragnarok\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;

trait AllowMentions
{
    /**
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object
     */
    public function allowMentions(AllowedMentionsBuilder $allowedMentions): self
    {
        $this->data['allowed_mentions'] = $allowedMentions->get();

        return $this;
    }

    /**
     * Disallow all mentions
     */
    public function noMentions(): self
    {
        return $this->allowMentions(new AllowedMentionsBuilder());
    }
}
