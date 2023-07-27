<?php

namespace Ragnarok\Fenrir\Rest\Helpers\Webhook;

use Ragnarok\Fenrir\Rest\Helpers\GetNew;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\Shared\SetAvatar;
use Ragnarok\Fenrir\Rest\Helpers\Webhook\Shared\SetName;

class CreateWebhookBuilder
{
    use GetNew;
    use SetAvatar;
    use SetName;

    private array $data = [];

    public function get(): array
    {
        return $this->data;
    }
}
