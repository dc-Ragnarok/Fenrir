<?php

declare(strict_types=1);

namespace Ragnarok\Fenrir\Enums\Parts;

enum EmbedTypes: string
{
    case RICH = 'rich';
    case IMAGE = 'image';
    case VIDEO = 'video';
    case GIFV = 'gifv';
    case ARTICLE = 'article';
    case LINK = 'link';
}
