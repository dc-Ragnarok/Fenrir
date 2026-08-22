<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\Modal;

use Ragnarok\Fenrir\Component\Component;
use Ragnarok\Fenrir\Enums\MessageComponentType;

/**
 * Lets the user attach files to a modal submission.
 *
 * @see https://discord.com/developers/docs/components/reference#file-upload
 */
class FileUpload extends Component
{
    public function __construct(
        private readonly string $customId,
        private readonly ?int $minValues = null,
        private readonly ?int $maxValues = null,
        private readonly ?bool $required = null,
        private readonly ?array $fileTypes = null,
        private readonly ?int $id = null
    ) {
    }

    public function get(): array
    {
        $data = [
            'type' => MessageComponentType::FILE_UPLOAD->value,
            'custom_id' => $this->customId,
        ];

        if (!is_null($this->minValues)) {
            $data['min_values'] = $this->minValues;
        }

        if (!is_null($this->maxValues)) {
            $data['max_values'] = $this->maxValues;
        }

        if (!is_null($this->required)) {
            $data['required'] = $this->required;
        }

        if (!is_null($this->fileTypes)) {
            $data['file_types'] = array_values($this->fileTypes);
        }

        if (!is_null($this->id)) {
            $data['id'] = $this->id;
        }

        return $data;
    }
}
