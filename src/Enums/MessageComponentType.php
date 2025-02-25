<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums;

use Ragnarok\Fenrir\Bitwise\Bitwise;

enum MessageComponentType: int
{
    case ACTION_ROW = 1;
    case BUTTON = 2;
    case STRING_SELECT = 3;
    case TEXT_INPUT = 4;
    case USER_SELECT = 5;
    case ROLE_SELECT = 6;
    case MENTIONABLE_SELECT = 7;
    case CHANNEL_SELECT = 8;
    case SECTION = 9;
    case TEXT_DISPLAY = 10;
    case THUMBNAIL = 11;
    case MEDIA_GALLERY = 12;
    case FILE = 13;
    case SEPERATOR = 14;
    case CONTENT_INVENTORY_ENTRY = 16;
    case CONTAINER = 17;

    public function version(): Bitwise
    {
        $bitwise = new Bitwise();

        if (in_array($this, [
            self::ACTION_ROW,
            self::BUTTON,
            self::STRING_SELECT,
            self::TEXT_INPUT,
            self::USER_SELECT,
            self::ROLE_SELECT,
            self::MENTIONABLE_SELECT,
            self::CHANNEL_SELECT,
            self::CONTENT_INVENTORY_ENTRY,
        ])) {
            $bitwise->add(MessageComponentVersion::v1);
        }

        if (in_array($this, [
            self::ACTION_ROW,
            self::BUTTON,
            self::STRING_SELECT,
            self::TEXT_INPUT,
            self::USER_SELECT,
            self::ROLE_SELECT,
            self::MENTIONABLE_SELECT,
            self::CHANNEL_SELECT,
            self::SECTION,
            self::TEXT_DISPLAY,
            self::THUMBNAIL,
            self::MEDIA_GALLERY,
            self::FILE,
            self::SEPERATOR,
            self::CONTENT_INVENTORY_ENTRY,
            self::CONTAINER,
        ])) {
            $bitwise->add(MessageComponentVersion::v2);
        }

        return $bitwise;
    }
}
