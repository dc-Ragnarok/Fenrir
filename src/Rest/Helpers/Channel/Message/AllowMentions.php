<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel\Message;

use Exan\Fenrir\Rest\Helpers\Channel\AllowedMentionsBuilder;

trait AllowMentions
{
    private AllowedMentionsBuilder $allowedMentions;

    /**
     * @see https://discord.com/developers/docs/resources/channel#allowed-mentions-object
     */
    public function allowMentions(AllowedMentionsBuilder $allowedMentions): self
    {
        $this->allowedMentions = $allowedMentions;

        return $this;
    }

    /**
     * Disallow all mentions
     */
    public function noMentions(): self
    {
        return $this->allowMentions(new AllowedMentionsBuilder());
    }

    public function getAllowedMentions(): ?AllowedMentionsBuilder
    {
        return $this->allowedMentions ?? null;
    }

    public function hasAllowedMentions(): bool
    {
        return isset($this->allowedMentions);
    }
}
