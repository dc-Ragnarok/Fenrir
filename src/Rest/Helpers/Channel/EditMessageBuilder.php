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

    private array $data = [];

    public function get(): MultipartBody|array
    {
        $data = $this->data;

        if ($this->hasAttachments()) {
            $data['attachments'] = array_map(
                fn (AttachmentBuilder $attachment) => $attachment->get(),
                $this->getAttachments()
            );
        }

        if ($this->hasComponents()) {
            $data['components'] = $this->getComponents()->get();
        }

        if ($this->hasEmbeds()) {
            $data['embeds'] = array_map(
                fn (EmbedBuilder $embed) => $embed->get(),
                $this->getEmbeds()
            );
        }

        if ($this->hasAllowedMentions()) {
            $data['allowed_mentions'] = $this->getAllowedMentions()->get();
        }

        if ($this->requiresMultipart()) {
            return $this->getMultipart($data);
        }

        return $data;
    }
}
