<?php

declare(strict_types=1);

namespace Exan\Fenrir\Interaction\Helpers;

use Discord\Http\Multipart\MultipartBody;
use Exan\Fenrir\Enums\Command\InteractionCallbackTypes;
use Exan\Fenrir\Rest\Helpers\Channel\EmbedBuilder;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddComponent;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddEmbed;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AddFile;
use Exan\Fenrir\Rest\Helpers\Channel\Message\AllowMentions;
use Exan\Fenrir\Rest\Helpers\Channel\Message\MultipartMessage;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetContent;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetFlags;
use Exan\Fenrir\Rest\Helpers\Channel\Message\SetTts;
use Exan\Fenrir\Rest\Helpers\GetNew;

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

    private array $data = [];

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
        $callbackData = $this->data;

        if ($this->hasComponents()) {
            $callbackData['components'] = $this->getComponents()->get();
        }

        if ($this->hasEmbeds()) {
            $callbackData['embeds'] = array_map(
                fn (EmbedBuilder $embed) => $embed->get(),
                $this->getEmbeds()
            );
        }

        if ($this->hasAllowedMentions()) {
            $callbackData['allowed_mentions'] = $this->getAllowedMentions()->get();
        }

        $data = [
            'type' => $this->type->value,
            'data' => $callbackData,
        ];

        if ($this->requiresMultipart()) {
            return $this->getMultipart($data);
        }

        return $data;
    }
}
