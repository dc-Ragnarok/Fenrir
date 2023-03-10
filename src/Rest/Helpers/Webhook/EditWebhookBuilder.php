<?php

declare(strict_types=1);

namespace Exan\Fenrir\Rest\Helpers\Webhook;

use Discord\Http\Multipart\MultipartBody;
use Exan\Fenrir\Rest\Helpers\Channel\AttachmentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\ComponentBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddAttachment;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddComponent;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddEmbed;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddFile;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AllowMentions;
use Exan\Fenrir\Rest\Helpers\Channel\Message\MultipartMessage;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetContent;
use Exan\Fenrir\Rest\Helpers\GetNew;

/**
 * @see https://discord.com/developers/docs/resources/webhook#edit-webhook-message
 */
class EditWebhookBuilder
{
    use GetNew;

    use SetContent;
    use AddEmbed;
    use AllowMentions;
    use AddComponent;
    use AddFile;
    use AddAttachment;
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
