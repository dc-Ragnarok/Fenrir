<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Rest\Helpers\Channel;

use Discord\Http\Multipart\MultipartBody;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddAttachment;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddComponent;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddEmbed;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AddFile;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\AllowMentions;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\MultipartMessage;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\SetContent;
use Ragnarok\Fenrir\Rest\Helpers\Channel\Message\SetFlags;
use Ragnarok\Fenrir\Rest\Helpers\GetNew;

class EditMessageBuilder
{
    use GetNew;

    use AddAttachment;
    use AddComponent;
    use AddEmbed;
    use AddFile;
    use AllowMentions;
    use SetContent;
    use SetFlags;
    use MultipartMessage;

    private $data = [];

    private $files = [];

    public function get(): MultipartBody|array
    {
        if ($this->requiresMultipart()) {
            return $this->getMultipart($this->data);
        }

        return $this->data;
    }
}
