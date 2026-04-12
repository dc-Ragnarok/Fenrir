<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

enum ComponentV2Type: int
{
    case ActionRow = 1;
    case Button = 2;
    case StringSelect = 3;
    case TextInput = 4;
    case UserSelect = 5;
    case RoleSelect = 6;
    case MentionableSelect = 7;
    case ChannelSelect = 8;
    case Section = 9;
    case TextDisplay = 10;
    case Thumbnail = 11;
    case MediaGallery = 12;
    case File = 13;
    case Separator = 14;
    case Container = 17;
    case Label = 18;
    case FileUpload = 19;
    case RadioGroup = 21;
    case CheckboxGroup = 22;
    case Checkbox = 23;

    /**
     * @return class-string
     */
    public function getClass(): ?string
    {
        return '\\Ragnarok\\Fenrir\\Parts\\ComponentV2\\' . $this->name;
    }
}
