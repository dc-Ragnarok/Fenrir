<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel\Message;

use Ragnarok\Fenrir\Rest\Helpers\Channel\ComponentBuilder;

trait AddComponent
{
    /**
     * @see https://discord.com/developers/docs/interactions/message-components#component-object
     */
    public function addComponent(ComponentBuilder $component): self
    {
        if (!isset($this->data['components'])) {
            $this->data['components'] = [];
        }

        $this->data['components'][] = $component->get();

        return $this;
    }
}
