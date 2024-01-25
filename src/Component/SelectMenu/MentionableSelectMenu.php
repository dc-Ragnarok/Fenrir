<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Component\SelectMenu;

use Ragnarok\Fenrir\Enums\SelectMenuType;

class MentionableSelectMenu extends SelectMenu
{
    use HasDefaultValues;

    protected SelectMenuType $type = SelectMenuType::Mentionable;

    public function get(): array
    {
        return [
            parent::get(),
            'default_values' => $this->defaultValues,
        ];
    }
}
