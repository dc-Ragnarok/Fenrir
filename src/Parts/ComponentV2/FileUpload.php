<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Parts\ComponentV2;

/**
 * @see https://docs.discord.com/developers/components/reference#file-upload
 */
class FileUpload extends Component
{
    public string $custom_id;
    public ?int $min_values;
    public ?int $max_values;
    public ?bool $required;
}
