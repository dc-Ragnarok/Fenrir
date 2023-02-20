<?php

declare(strict_types=1);

namespace Exan\Finrir\Rest\Helpers\Channel;

use Exan\Finrir\Rest\Helpers\Channel\Message\AddAttachment;
use Exan\Finrir\Rest\Helpers\Channel\Message\AddComponent;
use Exan\Finrir\Rest\Helpers\Channel\Message\AddEmbed;
use Exan\Finrir\Rest\Helpers\Channel\Message\AddFile;
use Exan\Finrir\Rest\Helpers\Channel\Message\AllowMentions;
use Exan\Finrir\Rest\Helpers\Channel\Message\MultipartMessage;
use Exan\Finrir\Rest\Helpers\Channel\Message\SetContent;
use Exan\Finrir\Rest\Helpers\Channel\Message\SetFlags;
use Exan\Finrir\Rest\Helpers\MultipartCapable;

class EditMessageBuilder implements MultipartCapable
{
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

    public function get(): array
    {
        return $this->data;
    }
}
