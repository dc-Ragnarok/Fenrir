<?php

declare(strict_types=1);

namespace Exan\Dhp\Rest\Helpers\Channel;

use Exan\Dhp\Rest\Helpers\Channel\Message\AddAttachment;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddComponent;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddEmbed;
use Exan\Dhp\Rest\Helpers\Channel\Message\AddFile;
use Exan\Dhp\Rest\Helpers\Channel\Message\AllowMentions;
use Exan\Dhp\Rest\Helpers\Channel\Message\MultipartMessage;
use Exan\Dhp\Rest\Helpers\Channel\Message\SetContent;
use Exan\Dhp\Rest\Helpers\Channel\Message\SetFlags;
use Exan\Dhp\Rest\Helpers\MultipartCapable;

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
