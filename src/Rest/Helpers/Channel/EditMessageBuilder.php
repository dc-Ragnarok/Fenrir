<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Channel;

use Discord\Http\Multipart\MultipartBody;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddAttachment;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddComponent;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddEmbed;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddFile;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AllowMentions;
use Exan\Fenrir\Rest\Helpers\Channel\Message\MultipartMessage;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetContent;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetFlags;
use Exan\Fenrir\Rest\Helpers\GetNew;

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
            $data['components'] = array_map(
                fn (ComponentBuilder $component) => $component->get(),
                $this->getComponents()
            );
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
