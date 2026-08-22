<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\V2;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Enums\MessageComponentType;

/**
 * An uploaded file shown in the message. Unlike a thumbnail or gallery item the
 * media must reference an attachment on the same message rather than a url.
 *
 * @see https://discord.com/developers/docs/components/reference#file
 */
class File extends Component
{
    public function __construct(
        private readonly UnfurledMedia $file,
        private readonly ?bool $spoiler = null,
        private readonly ?int $id = null
    ) {
    }

    public function get(): array
    {
        $data = [
            'type' => MessageComponentType::FILE->value,
            'file' => $this->file->get(),
        ];

        if (!is_null($this->spoiler)) {
            $data['spoiler'] = $this->spoiler;
        }

        if (!is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
