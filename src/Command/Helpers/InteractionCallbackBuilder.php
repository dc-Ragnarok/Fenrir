<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Command\Helpers;

use Discord\Http\Multipart\MultipartBody;
use Ragnarok\Fenrir\Enums\Command\InteractionCallbackTypes;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddComponent;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddEmbed;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddFile;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AllowMentions;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\MultipartMessage;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\SetContent;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\SetFlags;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\SetTts;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class InteractionCallbackBuilder
{
    use GetNew;

    use SetTts;
    use SetContent;
    use AddEmbed;
    use AllowMentions;
    use SetFlags;
    use AddComponent;
    use AddFile;
    use MultipartMessage;

    private InteractionCallbackTypes $type;

    private $data = [];

    private $files = [];

    public function setType(InteractionCallbackTypes $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): InteractionCallbackTypes
    {
        return $this->type;
    }

    public function get(): array|MultipartBody
    {
        $data = [
            'type' => $this->type->value,
            'data' => $this->data,
        ];

        if ($this->requiresMultipart()) {
            return $this->getMultipart($data);
        }

        return $data;
    }
}
