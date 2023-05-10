<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Guild\Guild\Shared;

use Ragnarok\Fenrir\Enums\DefaultMessageNotifications;

trait SetDefaultMessageNotifications
{
    public function setDefaultMessageNotifications(DefaultMessageNotifications $filter): static
    {
        $this->data['default_message_notifications'] = $filter->value;

        return $this;
    }

    public function getDefaultMessageNotifications(): ?DefaultMessageNotifications
    {
        return isset($this->data['default_message_notifications'])
            ? DefaultMessageNotifications::from($this->data['default_message_notifications'])
            : null;
    }
}
